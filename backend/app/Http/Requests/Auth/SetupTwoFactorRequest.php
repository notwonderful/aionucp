<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Enums\TwoFactorMethod;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class SetupTwoFactorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'method' => ['required', 'string', Rule::enum(TwoFactorMethod::class)],
        ];
    }
}
