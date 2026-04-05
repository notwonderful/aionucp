<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DataTransferObjects\PaymentResult;
use App\DataTransferObjects\PaymentVerification;
use App\DataTransferObjects\WebhookResult;
use App\Models\Donation;
use Illuminate\Http\Request;

interface PaymentGateway
{
    public function createPayment(Donation $donation, string $successUrl, string $cancelUrl): PaymentResult;

    public function verifyWebhook(Request $request): WebhookResult;

    public function verifyPayment(string $gatewayTransactionId): PaymentVerification;
}
