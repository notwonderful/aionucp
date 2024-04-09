<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BulkEmailController;
use App\Http\Controllers\Admin\MailItemController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(AdminMiddleware::class)
    ->prefix('admin')->as('admin.')->group(function () {

        Route::get('/', (AdminController::class))->name('index');
        Route::resource('users', UserController::class);
        Route::resource('categories', ProductCategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('mail-items', MailItemController::class)->only(['index', 'store']);

        Route::get('bulk-email', [BulkEmailController::class, 'index'])->name('bulk-email');
        Route::post('bulk-email', [BulkEmailController::class, 'sendBulkEmail'])->name('bulk-email');
});
