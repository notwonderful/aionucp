<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class AnnouncementSettingsUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'enabled' => ['required', 'boolean'],
            'text' => ['required', 'string', 'max:500'],
            'link_text' => ['required', 'string', 'max:100'],
            'link_url' => ['required', 'string', 'url:http,https', 'max:500'],
        ];
    }
}
