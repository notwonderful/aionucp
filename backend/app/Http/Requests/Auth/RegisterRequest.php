<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\ReCaptchaV3;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

final class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower($this->string('email')->trim()->value()),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'lowercase', 'regex:/^[^_\s]*$/u', 'min:3', 'max:45', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', new ReCaptchaV3('submitRegister')],
            'ref_code' => ['nullable', 'string', 'min:3', 'max:50'],
        ];
    }
}
