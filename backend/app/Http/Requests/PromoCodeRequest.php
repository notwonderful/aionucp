<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class PromoCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:5', 'max:1000', 'unique:promo_codes,code'],
            'toll' => ['required', 'integer', 'min:10', 'max:10000'],
            'user_id' => ['required', 'exists:App\Models\User,id'],
        ];
    }
}
