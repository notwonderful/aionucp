<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\GameServerContract;
use App\Contracts\PasswordEncrypterContract;
use App\Enums\EncryptionType;
use App\Services\Encryption\PasswordEncrypterFactory;
use App\Services\GameServer\GameServerManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class GameServerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GameServerManager::class);

        $this->app->bind(GameServerContract::class, function (Application $app) {
            return $app->make(GameServerManager::class)->current();
        });

        $this->app->bind(PasswordEncrypterContract::class, function () {
            return PasswordEncrypterFactory::create(EncryptionType::SHA1);
        });
    }
}
