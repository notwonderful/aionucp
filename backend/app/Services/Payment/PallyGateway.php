<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\DataTransferObjects\PaymentResult;
use App\DataTransferObjects\PaymentVerification;
use App\DataTransferObjects\WebhookResult;
use App\Enums\Currency;
use App\Exceptions\InvalidWebhookSignatureException;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

final class PallyGateway implements PaymentGateway
{
    private const API_URL = 'https://pal24.pro/api/v1';

    private function apiToken(): string
    {
        $token = config('services.pally.api_token');

        if (! is_string($token) || $token === '') {
            throw new \RuntimeException('Pally API token is not configured.');
        }

        return $token;
    }

    private function shopId(): string
    {
        $shopId = config('services.pally.shop_id');

        if (! is_string($shopId) || $shopId === '') {
            throw new \RuntimeException('Pally shop ID is not configured.');
        }

        return $shopId;
    }

    public function createPayment(Donation $donation, string $successUrl, string $cancelUrl): PaymentResult
    {
        $response = Http::withToken($this->apiToken())
            ->post(self::API_URL . '/bill/create', [
                'amount' => $donation->amount_money / 100,
                'order_id' => (string) $donation->id,
                'description' => "Donation #{$donation->id} - {$donation->amount_toll} Toll",
                'shop_id' => $this->shopId(),
                'currency_in' => $donation->currency->value,
                'type' => 'normal',
                'custom' => (string) $donation->id,
                'success_url' => $successUrl,
                'fail_url' => $cancelUrl,
            ]);

        $data = $response->json();

        if (! ($data['success'] ?? false)) {
            throw new \RuntimeException('Pally bill creation failed: ' . ($data['message'] ?? 'unknown error'));
        }

        return new PaymentResult(
            redirectUrl: $data['link_page_url'] ?? $data['link_url'] ?? '',
            gatewayTransactionId: $data['bill_id'] ?? '',
        );
    }

    public function verifyWebhook(Request $request): WebhookResult
    {
        $outSum = $request->input('OutSum', '');
        $invId = $request->input('InvId', '');
        $signature = $request->input('SignatureValue', '');
        $status = $request->input('Status', '');

        $expected = strtoupper(md5($outSum . ':' . $invId . ':' . $this->apiToken()));

        if (! hash_equals($expected, strtoupper((string) $signature))) {
            throw new InvalidWebhookSignatureException();
        }

        return new WebhookResult(
            success: in_array($status, ['SUCCESS', 'OVERPAID'], true),
            donationId: (int) $invId,
            gatewayTransactionId: $request->input('TrsId', ''),
            eventId: 'pally_' . $request->input('TrsId', '') . '_' . $invId,
        );
    }

    public function verifyPayment(string $gatewayTransactionId): PaymentVerification
    {
        $response = Http::withToken($this->apiToken())
            ->get(self::API_URL . '/bill/status', [
                'id' => $gatewayTransactionId,
            ]);

        $data = $response->json();

        $status = $data['status'] ?? '';
        $amount = (float) ($data['amount'] ?? 0);
        $currencyStr = strtoupper((string) ($data['currency_in'] ?? 'RUB'));

        return new PaymentVerification(
            paid: in_array($status, ['SUCCESS', 'OVERPAID'], true),
            amount: (int) round($amount * 100),
            currency: Currency::tryFrom($currencyStr) ?? Currency::RUB,
            status: $status,
        );
    }
}
