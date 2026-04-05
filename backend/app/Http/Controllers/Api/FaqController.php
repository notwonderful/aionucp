<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Cache::flexible('faq:public', [300, 900], function () {
            return FaqResource::collection(
                Faq::published()
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
            )->resolve();
        });

        return response()->json(['data' => $data]);
    }
}
