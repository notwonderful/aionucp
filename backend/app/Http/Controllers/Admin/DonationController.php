<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class DonationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $donations = QueryBuilder::for(Donation::class)
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::exact('gateway'),
                AllowedFilter::exact('user_id'),
            ])
            ->allowedSorts(['created_at', 'amount_toll', 'amount_money'])
            ->defaultSort('-created_at')
            ->with('user:id,name,email')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'data' => DonationResource::collection($donations),
            'meta' => [
                'current_page' => $donations->currentPage(),
                'last_page' => $donations->lastPage(),
                'per_page' => $donations->perPage(),
                'total' => $donations->total(),
            ],
        ]);
    }
}
