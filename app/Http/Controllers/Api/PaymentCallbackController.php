<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Payments\Handlers\PalychHandler;
use App\Services\Payments\Handlers\PayOpHandler;
use Illuminate\Http\Request;

final class PaymentCallbackController extends Controller
{
    public function palych(Request $request, PalychHandler $palychHandler): void
    {
        $palychHandler->handle($request);
    }

    public function payop(Request $request, PayOpHandler $payOpHandler): void
    {
        $payOpHandler->handle($request);
    }
}
