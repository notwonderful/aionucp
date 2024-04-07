<?php

namespace App\Http\Requests\Admin;

use App\Models\Game\Player;
use Illuminate\Foundation\Http\FormRequest;

class MailItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
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
