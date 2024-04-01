<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(AdminMiddleware::class)
    ->prefix('admin')->as('admin.')->group(function () {

        Route::get('/', (AdminController::class))->name('index');
        Route::resource('users', UserController::class);
        Route::resource('categories', ProductCategoryController::class);
});
