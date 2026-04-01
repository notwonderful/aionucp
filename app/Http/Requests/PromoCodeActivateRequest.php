<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\PromoCode;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PromoCodeActivateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'exists:'.PromoCode::class],
        ];
    }
}
