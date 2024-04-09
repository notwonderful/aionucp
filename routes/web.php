<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function(){
        Route::get('/index', 'create')->name('dashboard');
        Route::post('players/{player}/teleport', 'teleport')->name('teleport');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/donate', [DonateController::class, 'create'])->name('donate');
    Route::post('/donate', [DonateController::class, 'store'])->name('donate');

    Route::get('membership', [MembershipController::class, 'create'])->name('membership');
    Route::post('membership', [MembershipController::class, 'store'])->name('membership');

    Route::controller(ShopController::class)->prefix('shop')->as('shop.')->group(function () {
        Route::get('/',  'index')->name('index');
        Route::post('{product}/buy',  'buy')->name('buy');
    });

    Route::controller(RatingController::class)->prefix('rating')->as('rating.')->group(function(){
        Route::get('abyss', 'abyss')->name('abyss');
        Route::get('legion', 'legion')->name('legion');
    });

    Route::get('referral', [ReferralController::class, 'index'])->name('referral.index');
});

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ru'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back()->withInput();
})->name('lang.switch');

Route::get('ref/{ref}', [ReferralController::class, 'setReferralSession']);
