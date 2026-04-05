<?php

declare(strict_types=1);

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BulkEmailController;
use App\Http\Controllers\Admin\MailItemController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\WikiCategoryController as AdminWikiCategoryController;
use App\Http\Controllers\Admin\WikiEntryController as AdminWikiEntryController;
use App\Http\Controllers\Api\WikiController;
use App\Http\Controllers\Admin\ScheduleEntryController as AdminScheduleEntryController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::post('register', [RegisterController::class, 'store'])
            ->middleware('throttle:5,1');
        Route::post('login', [LoginController::class, 'store'])
            ->middleware('throttle:10,1');
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

Route::prefix('news')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('{slug}', [ArticleController::class, 'show']);
});

Route::get('faq', [FaqController::class, 'index']);
Route::get('schedule', [ScheduleController::class, 'index']);
Route::get('wiki', [WikiController::class, 'index']);
Route::get('settings/download', [SettingsController::class, 'download']);

Route::prefix('rating')->group(function () {
    Route::get('abyss', [RatingController::class, 'abyss']);
    Route::get('legion', [RatingController::class, 'legion']);
    Route::get('stats', [RatingController::class, 'stats']);
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
    Route::post('shop/{product}/buy', [ShopController::class, 'buy'])
        ->middleware('throttle:10,1');

    // Membership
    Route::post('membership', [MembershipController::class, 'store'])
        ->middleware('throttle:3,1');

    // Referral
    Route::get('referral', [ReferralController::class, 'index']);

    // Promo Codes
    Route::get('promocodes', [PromoCodeController::class, 'index']);
    Route::post('promocodes', [PromoCodeController::class, 'store']);
    Route::post('promocodes/activate', [PromoCodeController::class, 'activate']);

    // Tickets
    Route::get('tickets/categories', [TicketController::class, 'categories']);
    Route::get('tickets', [TicketController::class, 'index']);
    Route::post('tickets', [TicketController::class, 'store'])
        ->middleware('throttle:1,5');
    Route::get('tickets/{ticket}', [TicketController::class, 'show']);
    Route::post('tickets/{ticket}/reply', [TicketController::class, 'reply'])
        ->middleware('throttle:5,1');
    Route::post('tickets/{ticket}/close', [TicketController::class, 'close']);

    // Uploads
    Route::post('uploads/image', [UploadController::class, 'image'])
        ->middleware('throttle:10,1');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/read', [NotificationController::class, 'markAsRead']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markOneAsRead']);

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'role:'.implode('|', UserRole::adminRoles())])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', AdminController::class);

    Route::apiResource('users', AdminUserController::class)
        ->only(['index', 'show', 'update'])
        ->middleware('permission:'.Permission::USERS_VIEW->value);

    Route::put('users/{user}/role', [AdminUserController::class, 'assignRole'])
        ->middleware('permission:'.Permission::USERS_ROLES_MANAGE->value);

    Route::get('roles', [AdminUserController::class, 'roles'])
        ->middleware('permission:'.Permission::USERS_VIEW->value);

    Route::apiResource('categories', ProductCategoryController::class)
        ->middleware('permission:'.Permission::CATEGORIES_VIEW->value);

    Route::apiResource('products', ProductController::class)
        ->middleware('permission:'.Permission::PRODUCTS_VIEW->value);

    Route::apiResource('servers', ServerController::class)
        ->middleware('permission:'.Permission::SERVERS_VIEW->value);

    Route::post('mail-items', [MailItemController::class, 'store'])
        ->middleware('permission:'.Permission::MAIL_ITEMS_SEND->value);

    Route::post('bulk-email', [BulkEmailController::class, 'sendBulkEmail'])
        ->middleware('permission:'.Permission::BULK_EMAIL_SEND->value);

    Route::apiResource('news', AdminArticleController::class)
        ->parameters(['news' => 'article'])
        ->middleware('permission:'.Permission::NEWS_VIEW->value);

    Route::apiResource('faq', AdminFaqController::class)
        ->middleware('permission:'.Permission::FAQ_VIEW->value);

    Route::apiResource('wiki-categories', AdminWikiCategoryController::class)
        ->middleware('permission:'.Permission::WIKI_VIEW->value);

    Route::apiResource('wiki', AdminWikiEntryController::class)
        ->middleware('permission:'.Permission::WIKI_VIEW->value);

    Route::apiResource('schedule', AdminScheduleEntryController::class)
        ->middleware('permission:'.Permission::SCHEDULE_VIEW->value);

    Route::prefix('settings')->middleware('permission:'.Permission::SETTINGS_VIEW->value)->group(function () {
        Route::get('download', [AdminSettingsController::class, 'downloadShow']);
        Route::put('download', [AdminSettingsController::class, 'downloadUpdate'])
            ->middleware('permission:'.Permission::SETTINGS_EDIT->value);
    });

    Route::prefix('tickets')->middleware('permission:'.Permission::TICKETS_VIEW->value)->group(function () {
        Route::get('/', [AdminTicketController::class, 'index']);
        Route::get('{ticket}', [AdminTicketController::class, 'show']);
        Route::post('{ticket}/reply', [AdminTicketController::class, 'reply'])
            ->middleware('permission:'.Permission::TICKETS_REPLY->value);
        Route::post('{ticket}/close', [AdminTicketController::class, 'close'])
            ->middleware('permission:'.Permission::TICKETS_CLOSE->value);
        Route::post('{ticket}/open', [AdminTicketController::class, 'open'])
            ->middleware('permission:'.Permission::TICKETS_CLOSE->value);
    });
});
