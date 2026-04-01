<?php

namespace App\Http\Requests\Admin;

use App\Models\ProductCategory;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'parent_id' => ['nullable', 'exists:'.ProductCategory::class],
        ];
    }
}
