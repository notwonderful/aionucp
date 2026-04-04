<?php

declare(strict_types=1);

namespace App\Models\Game;

final class MailItem extends BaseGameModel
{
    public static function usesWorldDatabase(): bool
    {
        return true;
    }

    protected $table = 'mail';

    protected $primaryKey = 'mail_unique_id';

    protected $fillable = [
        'mail_unique_id',
        'mail_recipient_id',
        'sender_name',
        'mail_title',
        'mail_message',
        'attached_item_id',
        'attached_item_count',
        'attached_kinah_count',
        'express',
    ];
}
