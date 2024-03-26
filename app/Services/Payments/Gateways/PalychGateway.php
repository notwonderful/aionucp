<?php

namespace App\Services\Payments\Gateways;

use App\Services\Payments\Contracts\PaymentGatewayContract;
use App\Models\Donate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class PalychGateway implements PaymentGatewayContract
{
    public function processPayment(Donate $donate): RedirectResponse
    {
        $response = Http::withToken(config('services.palych.token'))->post('https://paypalych.com/api/v1/bill/create', [
            'shop_id' => config('services.palych.shop_id'),
            'currency_in' => $donate->currency,
            'amount' => $donate->amount,
            'custom' => $donate->id,
        ]);

        $result = $response->json();

        return $response->successful() && $result['success']
            ? redirect($result['link_page_url'])
            : back()->with('status', 'donate-error');
    }
}
