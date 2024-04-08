<?php

namespace App\Services\Payments\Gateways\PayOp;

use App\Models\Donate;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use Illuminate\Http\RedirectResponse;

class PayOpGateway implements PaymentGatewayContract
{
    public function processPayment(Donate $donate): RedirectResponse
    {
        $payOpApiClient = PayOpAdapter::makeApiClient();

        $response = $payOpApiClient->createPayment([
            'order' => [
                'id' => $donate->getKey(),
                'amount' => $donate->amount,
                'currency' => $donate->currency,
                'items' => [
                    'id' => 1,
                    'name' => 'Payment',
                    'price' => $donate->amount
                ]
            ],
            'payer' => [
                'email' => 'payment@notwonderful.github'
            ],
            'resultUrl' => url('payop/success'),
            'failPath' => url('payop/fail'),
        ]);

        if ($response === false) {
            return back()->with('status', __('Something went wrong!'));
        }

        return redirect($response);
    }
}
