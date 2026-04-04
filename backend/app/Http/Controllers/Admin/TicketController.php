<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Events\TicketMessageSent;
use App\Events\TicketStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketMessageResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketClosed;
use App\Notifications\TicketReplied;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Stevebauman\Purify\Facades\Purify;

final class TicketController extends Controller
{
    public function index(): JsonResponse
    {
        $tickets = QueryBuilder::for(Ticket::class)
            ->allowedFilters('status', 'category_id', 'user_id')
            ->allowedSorts('created_at', 'updated_at')
            ->with(['user:id,name,email', 'category', 'latestMessage.user'])
            ->withCount('messages')
            ->defaultSort('-updated_at')
            ->paginate(20);

        return response()->json([
            'data' => TicketResource::collection($tickets),
        ]);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        $ticket->load('category');

        $messages = $ticket->messages()
            ->with('user')
            ->latest()
            ->cursorPaginate(50);

        return response()->json([
            'data' => new TicketResource($ticket->loadCount('messages')),
            'messages' => TicketMessageResource::collection($messages),
            'pagination' => [
                'next_cursor' => $messages->nextCursor()?->encode(),
                'has_more' => $messages->hasMorePages(),
            ],
        ]);
    }

    public function reply(Request $request, Ticket $ticket): JsonResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:10000'],
        ]);

        $user = $request->user();
        assert($user instanceof User);

        $body = Purify::clean($validated['body']);

        $message = $ticket->messages()->create([
            'user_id' => $user->id,
            'body' => $body,
        ]);

        $ticket->touch();

        if ($ticket->status === TicketStatus::WAITING) {
            $ticket->update(['status' => TicketStatus::OPEN]);
            TicketStatusChanged::dispatch($ticket);
        }

        TicketMessageSent::dispatch($message);
        $ticket->user->notify(new TicketReplied($ticket, $message));

        return response()->json([
            'data' => new TicketMessageResource($message->load('user')),
        ], 201);
    }

    public function close(Ticket $ticket): JsonResponse
    {
        $ticket->close();

        TicketStatusChanged::dispatch($ticket);
        $ticket->user->notify(new TicketClosed($ticket));

        return response()->json([
            'message' => __('Ticket closed.'),
        ]);
    }

    public function open(Ticket $ticket): JsonResponse
    {
        $ticket->reopen();

        TicketStatusChanged::dispatch($ticket);

        return response()->json([
            'message' => __('Ticket reopened.'),
        ]);
    }
}
