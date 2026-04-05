<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\DonationGateway;
use App\Http\Controllers\Controller;
use App\Services\DonationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class WebhookController extends Controller
{
    public function handle(string $gateway, Request $request, DonationService $donationService): JsonResponse
    {
        $donationGateway = DonationGateway::tryFrom($gateway);

        if ($donationGateway === null) {
            abort(404);
        }

        $donationService->handleWebhook($donationGateway, $request);

        return response()->json(['status' => 'ok']);
    }
}
