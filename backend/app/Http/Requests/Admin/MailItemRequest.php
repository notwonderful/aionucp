<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\Game\Player;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class MailItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'exists:'.Player::class],
            'item_id' => ['required', 'integer'],
            'item_qty' => ['required', 'integer'],
        ];
    }
}
