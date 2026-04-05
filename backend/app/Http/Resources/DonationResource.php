<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Donation */
final class DonationResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        $isAdmin = $request->user()?->hasRole(['admin', 'super-admin']);

        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'gateway' => $this->gateway,
            'status' => $this->status,
            'amount_toll' => $this->amount_toll,
            'amount_money' => $this->amount_money / 100,
            'currency' => $this->currency,
            'exchange_rate' => $this->exchange_rate,
            'gateway_transaction_id' => $this->when($isAdmin, $this->gateway_transaction_id),
            'gateway_data' => $this->when($isAdmin, $this->gateway_data),
            'completed_at' => $this->completed_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
