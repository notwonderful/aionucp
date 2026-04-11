<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class GatewaySettingsUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limits' => ['required', 'array'],
            'limits.*.min_amount' => ['required', 'numeric', 'min:0'],
            'limits.*.max_amount' => ['required', 'numeric', 'min:0'],
            'limits.*.currency' => ['required', 'string', 'max:3'],
            'limits.*.enabled' => ['required', 'boolean'],
        ];
    }
}
