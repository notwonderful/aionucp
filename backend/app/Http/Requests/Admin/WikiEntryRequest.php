<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\WikiEntryType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;

final class WikiEntryRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'wiki_category_id' => ['required', 'exists:wiki_categories,id'],
            'type' => ['required', 'string', Rule::enum(WikiEntryType::class)],
            'content' => ['required', 'array'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'published' => ['required', 'boolean'],
        ];
    }

    protected function passedValidation(): void
    {
        $content = $this->input('content', []);

        if (isset($content['body']) && is_string($content['body'])) {
            $content['body'] = Purify::clean($content['body']);
        }

        $this->merge(['content' => $content]);
    }
}
