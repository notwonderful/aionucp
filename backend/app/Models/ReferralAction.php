<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ReferralActionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ReferralAction extends Model
{
    /** @use HasFactory<ReferralActionFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'referral_id',
        'aion_acc_id',
        'action',
        'created_at',
    ];

    /** @return BelongsTo<Referral, $this> */
    public function referral(): BelongsTo
    {
        return $this->belongsTo(
            related: Referral::class,
        );
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
