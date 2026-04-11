<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class DownloadSettingsUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'url:http,https', 'max:500'],
            'file_size' => ['required', 'string', 'max:50'],
            'discord_url' => ['required', 'string', 'url:http,https', 'max:500'],
            'min_requirements' => ['required', 'array'],
            'min_requirements.*.label' => ['required', 'string', 'max:50'],
            'min_requirements.*.value' => ['required', 'string', 'max:100'],
            'rec_requirements' => ['required', 'array'],
            'rec_requirements.*.label' => ['required', 'string', 'max:50'],
            'rec_requirements.*.value' => ['required', 'string', 'max:100'],
        ];
    }
}
