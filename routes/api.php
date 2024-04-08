<?php

use App\Http\Controllers\Api\PaymentCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(PaymentCallbackController::class)->prefix('payments/callback')->group(function () {
    Route::post('palych','palych');
    Route::post('payop','payop');
});
