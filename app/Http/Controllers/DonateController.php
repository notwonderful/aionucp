<?php

namespace App\Http\Controllers;

use App\Actions\ConvertCurrencyAction;
use App\Http\Requests\DonateRequest;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use App\Services\Payments\Gateways\PalychGateway;
use App\Services\Payments\Gateways\PayOp\PayOpGateway;
use App\Services\Payments\PaymentService;
use Illuminate\View\View;

final class DonateController extends Controller
{
    public function create(): View
    {
        return view('pages.donate');
    }

    /** @phpstan-ignore-next-line */
    public function store(DonateRequest $request, PaymentService $paymentService, ConvertCurrencyAction $convertCurrencyAction): mixed
    {
        /** @var string $paymentSystem */
        $paymentSystem = $request->validated('payment_system');
        $paymentGateway = $this->getPaymentGateway($paymentSystem);

        $amount = $convertCurrencyAction->execute($request);

        /** @var string $toll */
        $toll = $request->validated('amount');
        /** @var string $currency */
        $currency = $request->validated('currency');

        /** @phpstan-ignore-next-line */
        return $paymentService->createPayment(
            amount: $amount,
            toll: $toll,
            currency: $currency,
            paymentSystem: $paymentSystem,
            userId: auth()->id(),
            paymentGateway: $paymentGateway
        );
    }

    /** @phpstan-ignore class.notFound */
    protected function getPaymentGateway(string $paymentSystem): PaymentGatewayContract
    {
        return match ($paymentSystem) { // @phpstan-ignore return.type
            'palych' => new PalychGateway, // @phpstan-ignore class.notFound
            'payop' => new PayOpGateway, // @phpstan-ignore class.notFound
            default => throw new \InvalidArgumentException("Unsupported payment system: $paymentSystem"),
        };
    }
}
