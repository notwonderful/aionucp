<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class PaymentCallbackController extends Controller
{
    /** @phpstan-ignore class.notFound */
    public function palych(Request $request, \App\Services\Payments\Handlers\PalychHandler $palychHandler): void
    {
        $palychHandler->handle($request); // @phpstan-ignore class.notFound
    }

    /** @phpstan-ignore class.notFound */
    public function payop(Request $request, \App\Services\Payments\Handlers\PayOpHandler $payOpHandler): void
    {
        $payOpHandler->handle($request); // @phpstan-ignore class.notFound
    }
}
