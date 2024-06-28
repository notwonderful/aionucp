<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'processed_aion_acc_ids',
        'earned',
        'count',
        'history'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
        );
    }
}
