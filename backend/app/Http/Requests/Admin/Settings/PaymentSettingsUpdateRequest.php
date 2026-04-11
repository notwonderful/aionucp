<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class PaymentSettingsUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'enabled' => ['required', 'boolean'],
            'rate_rub' => ['required', 'numeric', 'min:0'],
            'rate_usd' => ['required', 'numeric', 'min:0'],
            'rate_eur' => ['required', 'numeric', 'min:0'],
            'bonus_tiers' => ['required', 'array'],
            'bonus_tiers.*.min_toll' => ['required', 'integer', 'min:1'],
            'bonus_tiers.*.bonus_percent' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
