<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\UserRole;
use App\Listeners\CreateReferralLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict();

        Gate::define('admin', function (User $user) {
            return $user->role === UserRole::ADMIN;
        });

        Event::listen([
            CreateReferralLink::class,
        ]);
    }
}
