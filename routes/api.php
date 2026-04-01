<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BulkEmailController;
use App\Http\Controllers\Admin\MailItemController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::post('register', [RegisterController::class, 'store']);
        Route::post('login', [LoginController::class, 'store']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'store'])
            ->middleware('throttle:3,15');
        Route::post('reset-password', [ResetPasswordController::class, 'store'])
            ->middleware('throttle:5,15');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [UserController::class, 'show']);
        Route::post('logout', [LoginController::class, 'destroy']);
        Route::put('password', [PasswordController::class, 'update']);

        Route::post('email/verify/resend', [EmailVerificationController::class, 'resend'])
            ->middleware('throttle:2,15');

        Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1']);
    });

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::prefix('rating')->group(function () {
    Route::get('abyss', [RatingController::class, 'abyss']);
    Route::get('legion', [RatingController::class, 'legion']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::post('players/{player}/teleport', [DashboardController::class, 'teleport']);

    // Profile
    Route::patch('profile', [ProfileController::class, 'update']);

    // Shop
    Route::get('shop', [ShopController::class, 'index']);
    Route::post('shop/{product}/buy', [ShopController::class, 'buy']);

    // Membership
    Route::post('membership', [MembershipController::class, 'store']);

    // Referral
    Route::get('referral', [ReferralController::class, 'index']);

    // Promo Codes
    Route::get('promocodes', [PromoCodeController::class, 'index']);
    Route::post('promocodes', [PromoCodeController::class, 'store']);
    Route::post('promocodes/activate', [PromoCodeController::class, 'activate']);

});

/*
|--------------------------------------------------------------------------
| Payment Callbacks
|--------------------------------------------------------------------------
*/

Route::controller(PaymentCallbackController::class)->prefix('payments/callback')->group(function () {
    Route::post('palych', 'palych');
    Route::post('payop', 'payop');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', AdminController::class);
    Route::apiResource('users', AdminUserController::class)->only(['index', 'show', 'update']);
    Route::apiResource('categories', ProductCategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::post('mail-items', [MailItemController::class, 'store']);
    Route::post('bulk-email', [BulkEmailController::class, 'sendBulkEmail']);
});
