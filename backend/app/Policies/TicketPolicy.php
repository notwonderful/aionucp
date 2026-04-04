<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

final class TicketPolicy
{
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function reply(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function close(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }
}
