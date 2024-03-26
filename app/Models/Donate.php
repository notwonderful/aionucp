<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\DonateStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donate extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'currency',
        'user_id',
        'payment_system',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'currency' => Currency::class,
            'status' => DonateStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
        );
    }
}
