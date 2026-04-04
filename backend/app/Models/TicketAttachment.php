<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

final class TicketAttachment extends Model
{
    protected $fillable = [
        'message_id',
        'user_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return Storage::disk('local')->url($this->path);
    }

    /** @return BelongsTo<TicketMessage, $this> */
    public function message(): BelongsTo
    {
        return $this->belongsTo(TicketMessage::class, 'message_id');
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
