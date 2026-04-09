<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class TicketReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Ticket $ticket,
        private readonly TicketMessage $message,
    ) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'ticket',
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'sender' => $this->message->user->name,
            'preview' => mb_substr(strip_tags($this->message->body), 0, 100),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Reply to ticket: :subject', ['subject' => $this->ticket->subject]))
            ->view('emails.ticket-replied', [
                'senderName' => $this->message->user->name,
                'ticketSubject' => $this->ticket->subject,
                'messagePreview' => mb_substr(strip_tags($this->message->body), 0, 200),
                'actionUrl' => url("/tickets?id={$this->ticket->id}"),
            ]);
    }
}
