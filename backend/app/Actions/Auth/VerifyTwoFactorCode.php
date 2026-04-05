<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Enums\TwoFactorMethod;
use App\Models\TwoFactorAuthentication;
use App\Models\User;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

final class VerifyTwoFactorCode
{
    public function __construct(
        private readonly Google2FA $google2FA,
    ) {}

    /** @throws ValidationException */
    public function execute(User $user, string $code): void
    {
        $this->guardAgainstTooManyAttempts($user);

        $twoFactor = $user->twoFactorAuthentication;

        if ($twoFactor === null || ! $twoFactor->enabled) {
            $this->recordFailedAttempt($user);
            throw ValidationException::withMessages(['code' => [__('The provided two-factor code is invalid.')]]);
        }

        if ($this->isRecoveryCode($twoFactor, $code)) {
            $this->clearAttempts($user);
            return;
        }

        $valid = match ($twoFactor->method) {
            TwoFactorMethod::APP => $this->google2FA->verifyKey($twoFactor->secret, $code),
            TwoFactorMethod::EMAIL => $this->verifyEmailCode($user, $code),
        };

        if (! $valid) {
            $this->recordFailedAttempt($user);
            throw ValidationException::withMessages(['code' => [__('The provided two-factor code is invalid.')]]);
        }

        $this->clearAttempts($user);
    }

    public function sendEmailCodeForLogin(User $user): void
    {
        $key = "2fa_email_throttle:{$user->id}";

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return;
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("2fa_email:{$user->id}", $code, now()->addMinutes(10));

        $user->notify(new TwoFactorCodeNotification($code));

        RateLimiter::hit($key, 60);
    }

    private function verifyEmailCode(User $user, string $code): bool
    {
        $cachedCode = Cache::get("2fa_email:{$user->id}");

        if ($cachedCode === null || $cachedCode !== $code) {
            return false;
        }

        Cache::forget("2fa_email:{$user->id}");

        return true;
    }

    private function guardAgainstTooManyAttempts(User $user): void
    {
        $attempts = (int) Cache::get("2fa_attempts:{$user->id}", 0);

        if ($attempts >= 5) {
            Cache::forget("2fa_token:{$user->id}");
            Cache::forget("2fa_attempts:{$user->id}");

            throw ValidationException::withMessages([
                'code' => [__('Too many failed attempts. Please sign in again.')],
            ]);
        }
    }

    private function recordFailedAttempt(User $user): void
    {
        $key = "2fa_attempts:{$user->id}";
        Cache::put($key, (int) Cache::get($key, 0) + 1, now()->addMinutes(10));
    }

    private function clearAttempts(User $user): void
    {
        Cache::forget("2fa_attempts:{$user->id}");
    }

    private function isRecoveryCode(TwoFactorAuthentication $twoFactor, string $code): bool
    {
        $recoveryCodes = $twoFactor->recovery_codes;
        $code = strtoupper(trim($code));

        if (! in_array($code, $recoveryCodes, true)) {
            return false;
        }

        $twoFactor->update([
            'recovery_codes' => array_values(array_filter(
                $recoveryCodes,
                static fn (string $c): bool => $c !== $code,
            )),
        ]);

        return true;
    }
}
