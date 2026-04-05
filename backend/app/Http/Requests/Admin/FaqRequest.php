<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Services\Localization\TranslatableRuleBuilder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class FaqRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...resolve(TranslatableRuleBuilder::class)->rules([
                'question' => ['string', 'min:3', 'max:500'],
                'answer' => ['string', 'min:3', 'max:2000'],
            ]),
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'published' => ['required', 'boolean'],
        ];
    }
}
