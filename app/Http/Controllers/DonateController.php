<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonateRequest;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use App\Services\Payments\Gateways\PalychGateway;
use App\Services\Payments\PaymentService;
use Illuminate\View\View;

class DonateController extends Controller
{
    public function create(): View
    {
        return view('pages.donate');
    }

    public function store(DonateRequest $request, PaymentService $paymentService)
    {
        $paymentGateway = $this->getPaymentGateway($request->validated('payment_system'));

        return $paymentService->createPayment(
            amount: $request->validated('amount'),
            currency: $request->validated('currency'),
            paymentSystem: $request->validated('payment_system'),
            userId: auth()->id(),
            paymentGateway: $paymentGateway
        );
    }

    protected function getPaymentGateway(string $paymentSystem): PaymentGatewayContract
    {
        return match ($paymentSystem) {
            'palych' => new PalychGateway(),
            default => throw new \InvalidArgumentException("Unsupported payment system: $paymentSystem"),
        };
    }
}
