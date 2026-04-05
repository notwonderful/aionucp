<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleEntryRequest;
use App\Http\Resources\ScheduleEntryResource;
use App\Models\ScheduleEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

final class ScheduleEntryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $entries = QueryBuilder::for(ScheduleEntry::class)
            ->allowedFilters('category', 'published')
            ->allowedSorts('sort_order', 'created_at', 'category')
            ->defaultSort('sort_order')
            ->paginate(50);

        return ScheduleEntryResource::collection($entries);
    }

    public function store(ScheduleEntryRequest $request): JsonResponse
    {
        $entry = ScheduleEntry::create($request->validated());

        return response()->json([
            'data' => new ScheduleEntryResource($entry),
            'message' => __('Schedule entry created successfully!'),
        ], 201);
    }

    public function show(ScheduleEntry $schedule): ScheduleEntryResource
    {
        return new ScheduleEntryResource($schedule);
    }

    public function update(ScheduleEntryRequest $request, ScheduleEntry $schedule): JsonResponse
    {
        $schedule->update($request->validated());

        return response()->json([
            'data' => new ScheduleEntryResource($schedule->fresh()),
            'message' => __('Schedule entry updated successfully!'),
        ]);
    }

    public function destroy(ScheduleEntry $schedule): JsonResponse
    {
        $schedule->delete();

        return response()->json(status: 204);
    }
}
