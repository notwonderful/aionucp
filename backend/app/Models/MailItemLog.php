<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class MailItemLog extends Model
{
    public $updatable = false;

    protected $fillable = [
        'admin_id',
        'player_name',
        'item_id',
        'item_qty',
    ];

    protected function casts(): array
    {
        return [
            'item_id' => 'integer',
            'item_qty' => 'integer',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
