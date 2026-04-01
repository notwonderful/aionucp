<?php

namespace App\Contracts;

use App\Mail\EmailBulkMessage;

interface BulkEmailSender
{
    /**
     * @param  iterable<\App\Models\User>  $users
     */
    public function sendBulkEmail(EmailBulkMessage $emailBulkMessage, iterable $users): void;
}
