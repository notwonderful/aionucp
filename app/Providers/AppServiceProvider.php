<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Listeners\CreateReferralLink;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role === UserRole::ADMIN;
        });

        Event::listen([
            CreateReferralLink::class,
        ]);
    }
}
