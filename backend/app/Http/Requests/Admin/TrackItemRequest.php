<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\Game\Inventory;
use App\Models\TrackedItem;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

final class TrackItemRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'item_unique_id' => ['required', 'integer', 'min:1'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $itemUniqueId = (int) $this->validated('item_unique_id');

                if (TrackedItem::where('item_unique_id', $itemUniqueId)->exists()) {
                    $validator->errors()->add('item_unique_id', __('This item is already being tracked.'));

                    return;
                }

                if (! Inventory::where('item_unique_id', $itemUniqueId)->exists()) {
                    $validator->errors()->add('item_unique_id', __('Item not found in game inventory.'));
                }
            },
        ];
    }
}
