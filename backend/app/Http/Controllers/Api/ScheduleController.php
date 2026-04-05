<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleEntryResource;
use App\Models\ScheduleEntry;
use Illuminate\Http\JsonResponse;

final class ScheduleController extends Controller
{
    public function index(): JsonResponse
    {
        $entries = ScheduleEntry::published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $grouped = $entries->groupBy('category');

        return response()->json([
            'data' => [
                'siege' => ScheduleEntryResource::collection($grouped->get('siege', collect())),
                'dredgion' => ScheduleEntryResource::collection($grouped->get('dredgion', collect())),
                'rift' => ScheduleEntryResource::collection($grouped->get('rift', collect())),
            ],
        ]);
    }
}
