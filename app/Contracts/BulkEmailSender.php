<?php

namespace App\Contracts;

use App\Mail\EmailBulkMessage;

interface BulkEmailSender
{
    public function sendBulkEmail(EmailBulkMessage $emailBulkMessage, iterable $users): void;
}
