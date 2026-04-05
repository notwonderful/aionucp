<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Currency;
use App\Enums\DonationGateway;
use App\Enums\DonationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'gateway',
        'status',
        'amount_toll',
        'bonus_toll',
        'amount_money',
        'currency',
        'exchange_rate',
        'gateway_transaction_id',
        'gateway_event_id',
        'gateway_data',
        'completed_at',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'gateway' => DonationGateway::class,
            'status' => DonationStatus::class,
            'currency' => Currency::class,
            'amount_toll' => 'integer',
            'bonus_toll' => 'integer',
            'amount_money' => 'integer',
            'exchange_rate' => 'float',
            'gateway_data' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @param Builder<Donation> $query */
    public function scopePending(Builder $query): void
    {
        $query->where('status', DonationStatus::PENDING);
    }
}
