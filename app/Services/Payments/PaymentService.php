<?php

namespace App\Services\Payments;

use App\Models\Donate;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use Illuminate\Http\RedirectResponse;

class PaymentService
{
    protected PaymentGatewayContract $paymentGateway;

    public function createPayment(int $amount, string $currency, string $paymentSystem, int $userId, PaymentGatewayContract $paymentGateway): RedirectResponse
    {
        $this->paymentGateway = $paymentGateway;

        $donate = Donate::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_system' => $paymentSystem,
            'user_id' => $userId,
        ]);

        return $this->paymentGateway->processPayment($donate);
    }
}
