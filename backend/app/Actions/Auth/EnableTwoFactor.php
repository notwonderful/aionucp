<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Enums\TwoFactorMethod;
use App\Models\TwoFactorAuthentication;
use App\Models\User;
use App\Notifications\TwoFactorCodeNotification;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

final class EnableTwoFactor
{
    public function __construct(
        private readonly Google2FA $google2FA,
        private readonly GenerateRecoveryCodes $generateRecoveryCodes,
    ) {}

    /** @return array{method: string, qr_uri?: string} */
    public function execute(User $user, TwoFactorMethod $method): array
    {
        if ($user->hasTwoFactorEnabled()) {
            throw ValidationException::withMessages([
                'method' => [__('Two-factor authentication is already enabled.')],
            ]);
        }

        $user->twoFactorAuthentication()->delete();

        $secret = null;
        $qrUri = null;

        if ($method === TwoFactorMethod::APP) {
            $secret = $this->google2FA->generateSecretKey();
            $qrUri = $this->google2FA->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret,
            );
        }

        if ($method === TwoFactorMethod::EMAIL) {
            $this->sendEmailCode($user);
        }

        TwoFactorAuthentication::create([
            'user_id' => $user->id,
            'method' => $method,
            'secret' => $secret,
            'recovery_codes' => $this->generateRecoveryCodes->execute(),
            'enabled' => false,
        ]);

        $result = ['method' => $method->value];

        if ($qrUri !== null) {
            $result['qr_svg'] = $this->generateQrSvgDataUri($qrUri);
            $result['secret'] = $secret;
        }

        return $result;
    }

    private function generateQrSvgDataUri(string $qrUri): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(192),
            new SvgImageBackEnd(),
        );

        $svg = (new Writer($renderer))->writeString($qrUri);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    private function sendEmailCode(User $user): void
    {
        $key = "2fa_email_throttle:{$user->id}";

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'method' => [__('Please wait :seconds seconds before requesting a new code.', ['seconds' => $seconds])],
            ]);
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("2fa_email:{$user->id}", $code, now()->addMinutes(10));

        $user->notify(new TwoFactorCodeNotification($code));

        RateLimiter::hit($key, 60);
    }
}
