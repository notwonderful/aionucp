<?php

namespace App\Services;

use App\Contracts\BulkEmailSender;
use App\Jobs\SendBulkEmailJob;
use App\Mail\EmailBulkMessage;

class EmailBulkService implements BulkEmailSender
{
    public function sendBulkEmail(EmailBulkMessage $emailBulkMessage, iterable $users): void
    {
        dispatch(new SendBulkEmailJob($emailBulkMessage, $users));
    }
}
