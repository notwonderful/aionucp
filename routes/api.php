<?php

use App\Http\Controllers\Api\DonateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('payments/callback', [DonateController::class, 'handlePaymentCallback'])->name('payments.callback');
