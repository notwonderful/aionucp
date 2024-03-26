<?php

namespace App\Services\Payments\Contracts;

use App\Models\Donate;
use Illuminate\Http\RedirectResponse;

interface PaymentGatewayContract
{
    public function processPayment(Donate $donate): RedirectResponse;
}
