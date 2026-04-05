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
            ->line(__('Your verification code is: **:code**', ['code' => $this->code]))
            ->line(__('This code will expire in 10 minutes.'))
            ->line(__('If you did not request this code, please ignore this email.'));
    }
}
