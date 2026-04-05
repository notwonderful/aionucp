<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Contracts\GameServerContract;
use App\Models\Game\Player;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class MailItemRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'player_name' => [
                'required',
                'string',
                'max:50',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $gameServer = app(GameServerContract::class);
                    $exists = $gameServer->playerExists((string) $value);

                    if (! $exists) {
                        $fail(__('Player not found.'));
                    }
                },
            ],
            'item_id' => ['required', 'integer', 'min:1'],
            'item_qty' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }
}
