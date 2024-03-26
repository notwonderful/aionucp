<?php

use App\Http\Controllers\DonateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/donate', [DonateController::class, 'create'])->name('donate');
    Route::post('/donate', [DonateController::class, 'store'])->name('donate');

    Route::controller(RatingController::class)->prefix('rating')->as('rating.')->group(function(){
        Route::get('abyss', 'abyss')->name('abyss');
    });
});

require __DIR__.'/auth.php';
