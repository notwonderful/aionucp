<?php

namespace App\Http\Controllers;

use App\Actions\ConvertCurrencyAction;
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

    public function store(DonateRequest $request, PaymentService $paymentService, ConvertCurrencyAction $convertCurrencyAction)
    {
        $paymentGateway = $this->getPaymentGateway($request->validated('payment_system'));

        $amount = $convertCurrencyAction->execute($request);

        return $paymentService->createPayment(
            amount: $amount,
            toll: $request->validated('amount'),
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
