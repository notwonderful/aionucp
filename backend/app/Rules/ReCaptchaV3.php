<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final readonly class ReCaptchaV3 implements ValidationRule
{
    public function __construct(
        private ?string $action = null,
        private ?float $minScore = 0.5
    ) {}

    /**
     * Run the validation rule.
     *
     * @throws ConnectionException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $siteVerify = Http::asForm()
            ->timeout(5)
            ->retry(2, 100)
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha_v3.secret_key'),
                'response' => $value,
            ]);

        if ($siteVerify->failed()) {
            $fail(__('Google reCAPTCHA was not able to verify the form, please try again.'));

            return;
        }

        if ($siteVerify->successful()) {
            /** @var array{success: bool, action?: string, score?: float} $body */
            $body = $siteVerify->json();
            Log::debug('reCAPTCHA response', $body);

            if ($body['success'] !== true) {
                $fail(__('Your form submission failed the Google reCAPTCHA verification, please try again.'));

                return;
            }

            if (! is_null($this->action) && $this->action !== ($body['action'] ?? null)) {
                $fail(__('The reCAPTCHA action did not match, please try again.'));

                return;
            }

            if (! is_null($this->minScore) && $this->minScore > ($body['score'] ?? 0)) {
                $fail(__('The Google reCAPTCHA verification score was too low, please try again.'));

                return;
            }
        }
    }
}
