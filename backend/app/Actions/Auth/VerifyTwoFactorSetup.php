<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Enums\TwoFactorMethod;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

final class VerifyTwoFactorSetup
{
    public function __construct(
        private readonly Google2FA $google2FA,
    ) {}

    /** @return list<string> */
    public function execute(User $user, string $code): array
    {
        $twoFactor = $user->twoFactorAuthentication;

        if ($twoFactor === null || $twoFactor->enabled) {
            throw ValidationException::withMessages([
                'code' => [__('No pending two-factor setup found.')],
            ]);
        }

        $valid = match ($twoFactor->method) {
            TwoFactorMethod::APP => $this->google2FA->verifyKey($twoFactor->secret, $code),
            TwoFactorMethod::EMAIL => $this->verifyEmailCode($user, $code),
        };

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => [__('The provided code is invalid.')],
            ]);
        }

        $twoFactor->update([
            'enabled' => true,
            'verified_at' => now(),
        ]);

        return $twoFactor->recovery_codes;
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
}
