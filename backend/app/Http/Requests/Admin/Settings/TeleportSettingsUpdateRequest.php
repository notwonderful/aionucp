<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class TeleportSettingsUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'elyos_x' => ['required', 'numeric'],
            'elyos_y' => ['required', 'numeric'],
            'elyos_z' => ['required', 'numeric'],
            'elyos_map' => ['required', 'integer'],
            'asmodians_x' => ['required', 'numeric'],
            'asmodians_y' => ['required', 'numeric'],
            'asmodians_z' => ['required', 'numeric'],
            'asmodians_map' => ['required', 'integer'],
            'cooldown_minutes' => ['required', 'integer', 'min:1'],
        ];
    }
}
