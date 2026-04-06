<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\TrackItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrackItemRequest;
use App\Http\Resources\ItemTrackerLogResource;
use App\Http\Resources\TrackedItemResource;
use App\Models\ItemTrackerLog;
use App\Models\TrackedItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ItemTrackerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = QueryBuilder::for(TrackedItem::class)
            ->allowedFilters([
                AllowedFilter::exact('item_id'),
                AllowedFilter::partial('last_owner_name'),
                AllowedFilter::exact('is_deleted'),
            ])
            ->allowedSorts(['last_changed_at', 'first_seen_at', 'item_id', 'enchant'])
            ->defaultSort('-last_changed_at')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'data' => TrackedItemResource::collection($items),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function logs(Request $request): JsonResponse
    {
        $logs = QueryBuilder::for(ItemTrackerLog::class)
            ->allowedFilters([
                AllowedFilter::exact('item_unique_id'),
                AllowedFilter::partial('old_owner_name'),
                AllowedFilter::partial('new_owner_name'),
                AllowedFilter::exact('event_type'),
            ])
            ->allowedSorts(['logged_at'])
            ->defaultSort('-logged_at')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'data' => ItemTrackerLogResource::collection($logs),
            'meta' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
            ],
        ]);
    }

    public function store(TrackItemRequest $request, TrackItemAction $action): JsonResponse
    {
        $trackedItem = $action->execute((int) $request->validated('item_unique_id'));

        return response()->json([
            'message' => __('Item is now being tracked.'),
            'data' => new TrackedItemResource($trackedItem),
        ], 201);
    }

    public function destroy(TrackedItem $trackedItem): JsonResponse
    {
        ItemTrackerLog::where('item_unique_id', $trackedItem->item_unique_id)->delete();
        $trackedItem->delete();

        return response()->json(['message' => __('Item removed from tracking.')]);
    }
}
