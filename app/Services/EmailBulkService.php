<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BulkEmailSender;
use App\Jobs\SendBulkEmailJob;
use App\Mail\EmailBulkMessage;
use App\Models\User;

class EmailBulkService implements BulkEmailSender
{
    /**
     * @param  iterable<User>  $users
     */
    public function sendBulkEmail(EmailBulkMessage $emailBulkMessage, iterable $users): void
    {
        dispatch(new SendBulkEmailJob($emailBulkMessage, $users));
    }
}
