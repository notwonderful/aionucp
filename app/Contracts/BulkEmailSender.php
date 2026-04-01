<?php

namespace App\Contracts;

use App\Mail\EmailBulkMessage;
use App\Models\User;

interface BulkEmailSender
{
    /**
     * @param  iterable<User>  $users
     */
    public function sendBulkEmail(EmailBulkMessage $emailBulkMessage, iterable $users): void;
}
