<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class DonationCompletedNotification extends Notification
{
    public function __construct(
        private readonly Donation $donation,
    ) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Donation Completed'))
            ->greeting(__('Thank you for your donation!'))
            ->line(__('Your donation of :toll Toll has been credited to your account.', [
                'toll' => $this->donation->amount_toll,
            ]))
            ->line(__('Amount paid: :amount :currency', [
                'amount' => $this->donation->amount_money,
                'currency' => $this->donation->currency->value,
            ]));
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'donation',
            'donation_id' => $this->donation->id,
            'text' => __('Your donation of :toll Toll has been credited.', [
                'toll' => $this->donation->amount_toll,
            ]),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
