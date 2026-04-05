<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\Currency;
use App\Enums\DonationGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\User;
use App\Services\DonationService;
use App\Settings\GatewaySettings;
use App\Settings\PaymentSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class DonateController extends Controller
{
    public function methods(PaymentSettings $paymentSettings, GatewaySettings $gatewaySettings): JsonResponse
    {
        $gateways = [];

        foreach (DonationGateway::cases() as $gateway) {
            if (! $gatewaySettings->isGatewayEnabled($gateway)) {
                continue;
            }

            $currency = $gateway->currency();
            $limits = $gatewaySettings->getGatewayLimits($gateway);

            $gateways[] = [
                'gateway' => $gateway->value,
                'label' => $gateway->label(),
                'icon' => $gateway->icon(),
                'currency' => [
                    'code' => $currency->value,
                    'symbol' => $currency->symbol(),
                ],
                'min_amount' => $limits['min_amount'] ?? 0,
                'max_amount' => $limits['max_amount'] ?? 0,
            ];
        }

        return response()->json([
            'data' => $gateways,
            'rates' => [
                Currency::RUB->value => $paymentSettings->rate_rub,
                Currency::USD->value => $paymentSettings->rate_usd,
                Currency::EUR->value => $paymentSettings->rate_eur,
            ],
        ]);
    }

    public function store(CreateDonationRequest $request, DonationService $donationService): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        try {
            $gateway = DonationGateway::from($request->validated('gateway'));
            $frontendUrl = config('app.frontend_url');

            $result = $donationService->create(
                user: $user,
                gateway: $gateway,
                amountToll: $request->validated('amount_toll'),
                successUrl: "{$frontendUrl}/donate?status=success",
                cancelUrl: "{$frontendUrl}/donate?status=cancelled",
            );

            return response()->json([
                'data' => ['redirect_url' => $result->redirectUrl],
            ]);
        } catch (\Throwable $e) {
            Log::error('Donation creation failed', [
                'user_id' => $user->id,
                'gateway' => $request->validated('gateway'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => __('Payment is temporarily unavailable. Please try again later.'),
            ], 503);
        }
    }

    public function history(Request $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $donations = $user->donations()
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => DonationResource::collection($donations),
            'meta' => [
                'current_page' => $donations->currentPage(),
                'last_page' => $donations->lastPage(),
                'per_page' => $donations->perPage(),
                'total' => $donations->total(),
            ],
        ]);
    }
}
