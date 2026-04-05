<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Localization\TranslatableRuleBuilder;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
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

        VerifyEmail::toMailUsing(function (object $notifiable, string $url): MailMessage {
            $frontendUrl = config('app.frontend_url').'/verify-email/confirm?verify_url='.urlencode($url);

            return (new MailMessage)
                ->subject(__('Verify Email Address'))
                ->line(__('Please click the button below to verify your email address.'))
                ->action(__('Verify Email Address'), $frontendUrl)
                ->line(__('If you did not create an account, no further action is required.'));
        });
    }
}
