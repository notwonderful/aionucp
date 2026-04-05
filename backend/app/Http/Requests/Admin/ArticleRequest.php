<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Services\Localization\TranslatableRuleBuilder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class ArticleRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...resolve(TranslatableRuleBuilder::class)->rules([
                'title' => ['string', 'min:3', 'max:255'],
                'excerpt' => ['string', 'max:1000'],
                'body' => ['string'],
            ]),
            'tag' => ['required', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
