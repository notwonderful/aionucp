<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Contracts\GameServerContract;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

final class MailItemRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'player_name' => ['required', 'string', 'max:50'],
            'item_id' => ['required', 'integer', 'min:1'],
            'item_qty' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }

    public function after(GameServerContract $gameServer): array
    {
        return [
            function (Validator $validator) use ($gameServer) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                if (! $gameServer->playerExists($this->validated('player_name'))) {
                    $validator->errors()->add('player_name', __('Player not found.'));
                }
            },
        ];
    }
}
