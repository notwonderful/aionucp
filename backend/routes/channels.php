<?php

declare(strict_types=1);

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function (User $user, int $id) {
    return $user->id === $id;
});

Broadcast::channel('tickets.{ticketId}', function (User $user, string $ticketId) {
    $ticket = Ticket::find($ticketId);

    return $ticket && $user->id === $ticket->user_id;
});
