<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class TwoFactorCodeNotification extends Notification
{

    public function __construct(
        private readonly string $code,
    ) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Your two-factor authentication code'))
            ->view('emails.two-factor-code', [
                'code' => $this->code,
            ]);
    }
}
