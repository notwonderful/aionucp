<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreTicketMessageRequest;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Resources\TicketCategoryResource;
use App\Http\Resources\TicketMessageResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

final class TicketController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $tickets = Ticket::query()
            ->where('user_id', $user->id)
            ->with(['category', 'latestMessage.user'])
            ->withCount('messages')
            ->latest('updated_at')
            ->paginate(20);

        return response()->json([
            'data' => TicketResource::collection($tickets),
        ]);
    }

    public function store(StoreTicketRequest $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $ticket = Ticket::create([
            'subject' => $request->validated('subject'),
            'category_id' => $request->validated('category_id'),
            'user_id' => $user->id,
        ]);

        $ticket->messages()->create([
            'user_id' => $user->id,
            'body' => $request->validated('body'),
        ]);

        $ticket->load(['category', 'messages.user']);

        return response()->json([
            'data' => new TicketResource($ticket),
            'message' => __('Ticket created successfully.'),
        ], 201);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        Gate::authorize('view', $ticket);

        $ticket->load(['category', 'messages.user']);

        return response()->json([
            'data' => new TicketResource($ticket),
            'messages' => TicketMessageResource::collection($ticket->messages),
        ]);
    }

    public function reply(StoreTicketMessageRequest $request, Ticket $ticket): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $message = $ticket->messages()->create([
            'user_id' => $user->id,
            'body' => $request->validated('body'),
        ]);

        $ticket->touch();

        if ($ticket->status === TicketStatus::OPEN) {
            $ticket->update(['status' => TicketStatus::WAITING]);
        }

        return response()->json([
            'data' => new TicketMessageResource($message->load('user')),
        ], 201);
    }

    public function close(Ticket $ticket): JsonResponse
    {
        Gate::authorize('close', $ticket);

        $ticket->close();

        return response()->json([
            'message' => __('Ticket closed.'),
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = TicketCategory::query()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => TicketCategoryResource::collection($categories),
        ]);
    }
}
