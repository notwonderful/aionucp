<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WikiCategoryResource;
use App\Http\Resources\WikiEntryResource;
use App\Models\WikiCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class WikiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Cache::rememberForever('wiki:public', function () {
            $categories = WikiCategory::published()
                ->orderBy('sort_order')
                ->with(['entries' => fn ($q) => $q->published()->orderBy('sort_order')->orderBy('id')])
                ->get();

            return $categories->map(fn ($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'entries' => WikiEntryResource::collection($cat->entries),
            ])->values();
        });

        return response()->json(['data' => $data]);
    }
}
