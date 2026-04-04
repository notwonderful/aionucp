<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Services\Localization\TranslatableRuleBuilder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class ProductRequest extends FormRequest
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
                'name' => ['string', 'min:3', 'max:255'],
                'description' => ['string'],
            ]),
            'category_id' => ['required', 'exists:product_categories,id'],
            'item_id' => ['required', 'integer'],
            'item_qty' => ['required', 'integer'],
            'toll' => ['required', 'integer'],
            'image' => ['required_without:edit', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
