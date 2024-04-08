<?php

namespace App\Services\Payments\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface PaymentCallbackContract
{
    public function handle(Request $request): RedirectResponse;
}
