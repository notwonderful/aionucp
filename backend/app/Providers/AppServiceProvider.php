<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Localization\TranslatableRuleBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TranslatableRuleBuilder::class, function () {
            /** @var list<string> $locales */
            $locales = config('app.locales', ['en']);

            /** @var string $defaultLocale */
            $defaultLocale = config('app.locale', 'en');

            return new TranslatableRuleBuilder($locales, $defaultLocale);
        });
    }

    public function boot(): void
    {
        Model::shouldBeStrict();

//        Password::defaults(fn () => Password::min(8)
//            ->letters()
//            ->mixedCase()
//            ->numbers()
//            ->uncompromised()
//        );
    }
}
