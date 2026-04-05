<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\GameServerContract;
use App\DataTransferObjects\PaymentResult;
use App\Enums\DonationGateway;
use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use App\Notifications\DonationCompletedNotification;
use App\Services\Payment\PaymentGatewayFactory;
use App\Settings\PaymentSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DonationService
{
    public function __construct(
        private readonly PaymentGatewayFactory $gatewayFactory,
        private readonly PaymentSettings $paymentSettings,
        private readonly GameServerContract $gameServer,
    ) {}

    public function create(User $user, DonationGateway $gateway, int $amountToll, string $successUrl, string $cancelUrl): PaymentResult
    {
        $currency = $gateway->currency();
        $rate = $this->paymentSettings->getRate($currency);
        $amountMoney = $this->paymentSettings->tollToMoney($amountToll, $currency);

        $donation = Donation::create([
            'user_id' => $user->id,
            'gateway' => $gateway,
            'status' => DonationStatus::PENDING,
            'amount_toll' => $amountToll,
            'amount_money' => $amountMoney,
            'currency' => $currency,
            'exchange_rate' => $rate,
        ]);

        $paymentGateway = $this->gatewayFactory->make($gateway);
        $result = $paymentGateway->createPayment($donation, $successUrl, $cancelUrl);

        $donation->update([
            'gateway_transaction_id' => $result->gatewayTransactionId,
        ]);

        return $result;
    }

    public function handleWebhook(DonationGateway $gateway, Request $request): void
    {
        $paymentGateway = $this->gatewayFactory->make($gateway);
        $webhookResult = $paymentGateway->verifyWebhook($request);

        if (! $webhookResult->success) {
            return;
        }

        $cacheKey = "stripe_event:{$webhookResult->eventId}";

        if (Cache::has($cacheKey)) {
            return;
        }

        $lockKey = "donation_webhook_{$webhookResult->donationId}";
        $lock = Cache::lock($lockKey, 30);

        try {
            $lock->block(5);
        } catch (\Illuminate\Contracts\Cache\LockTimeoutException) {
            throw new \RuntimeException("Failed to acquire lock for donation webhook: {$webhookResult->donationId}");
        }

        try {
            DB::transaction(function () use ($webhookResult, $paymentGateway, $cacheKey) {
                /** @var Donation|null $donation */
                $donation = Donation::query()
                    ->where('id', $webhookResult->donationId)
                    ->where('status', DonationStatus::PENDING)
                    ->lockForUpdate()
                    ->first();

                if ($donation === null) {
                    return;
                }

                if (Donation::query()->where('gateway_event_id', $webhookResult->eventId)->exists()) {
                    return;
                }

                $verification = $paymentGateway->verifyPayment($webhookResult->gatewayTransactionId);

                if (! $verification->paid) {
                    $donation->update([
                        'status' => DonationStatus::FAILED,
                        'gateway_transaction_id' => $webhookResult->gatewayTransactionId,
                        'gateway_event_id' => $webhookResult->eventId,
                    ]);

                    return;
                }

                if ($verification->currency !== $donation->currency) {
                    Log::warning('Donation currency mismatch', [
                        'donation_id' => $donation->id,
                        'expected' => $donation->currency->value,
                        'received' => $verification->currency->value,
                    ]);

                    $donation->update([
                        'status' => DonationStatus::FAILED,
                        'gateway_event_id' => $webhookResult->eventId,
                    ]);

                    return;
                }

                if ($verification->amount !== $donation->amount_money) {
                    Log::warning('Donation amount mismatch', [
                        'donation_id' => $donation->id,
                        'expected' => $donation->amount_money,
                        'received' => $verification->amount,
                    ]);

                    $donation->update([
                        'status' => DonationStatus::FAILED,
                        'gateway_event_id' => $webhookResult->eventId,
                    ]);

                    return;
                }

                $donation->update([
                    'status' => DonationStatus::COMPLETED,
                    'gateway_transaction_id' => $webhookResult->gatewayTransactionId,
                    'gateway_event_id' => $webhookResult->eventId,
                    'completed_at' => now(),
                ]);

                Cache::put($cacheKey, true, now()->addHours(24));

                $this->gameServer->incrementBalance($donation->user->aion_acc_id, $donation->amount_toll);

                $donation->user->notify(new DonationCompletedNotification($donation));
            });
        } finally {
            $lock->release();
        }
    }
}
