<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TicketMessage */
final class TicketMessageResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'is_admin' => $this->user->hasRole(['admin', 'super-admin']),
            ],
            'body' => $this->body,
            'created_at' => $this->created_at,
        ];
    }
}
