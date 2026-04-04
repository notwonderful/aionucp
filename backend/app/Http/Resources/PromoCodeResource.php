<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PromoCode */
final class PromoCodeResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'toll' => $this->toll,
            'type' => $this->type,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'created_at' => $this->created_at,
        ];
    }
}
