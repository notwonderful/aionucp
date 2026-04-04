<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\ProductCategory;
use App\Services\Localization\TranslatableRuleBuilder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class ProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...resolve(TranslatableRuleBuilder::class)->rules([
                'name' => ['string', 'max:255'],
            ]),
            'parent_id' => ['nullable', 'exists:'.ProductCategory::class],
        ];
    }
}
