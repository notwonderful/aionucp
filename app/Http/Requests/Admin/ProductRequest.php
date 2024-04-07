<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:product_categories,id'],
            'item_id' => ['required', 'integer'],
            'item_qty' => ['required', 'integer'],
            'toll' => ['required', 'integer'],
            'image' => ['required_without:edit', 'image'],
        ];
    }
}
