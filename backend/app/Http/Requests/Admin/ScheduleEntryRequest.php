<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class ScheduleEntryRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'in:siege,dredgion,rift'],
            'name' => ['required', 'string', 'max:100'],
            'metadata' => ['required', 'array'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'published' => ['required', 'boolean'],
        ];
    }
}
