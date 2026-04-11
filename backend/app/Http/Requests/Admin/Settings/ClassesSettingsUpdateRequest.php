<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class ClassesSettingsUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'classes' => ['required', 'array', 'min:1'],
            'classes.*.id' => ['required', 'integer'],
            'classes.*.name' => ['required', 'string', 'max:50'],
            'classes.*.role' => ['required', 'string', 'max:50'],
            'classes.*.description' => ['required', 'string', 'max:500'],
            'classes.*.hasIcon' => ['required', 'boolean'],
            'classes.*.iconId' => ['required', 'integer'],
            'classes.*.gradient' => ['required', 'string', 'max:200'],
            'classes.*.stats' => ['required', 'array', 'size:3'],
            'classes.*.stats.*.name' => ['required', 'string', 'max:30'],
            'classes.*.stats.*.value' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}
