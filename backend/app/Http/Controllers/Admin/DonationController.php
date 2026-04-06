<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\DonationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function stats(): JsonResponse
    {
        $completed = Donation::where('status', DonationStatus::COMPLETED);

        $totalRevenue = (clone $completed)->sum('amount_money') / 100;
        $totalToll = (clone $completed)->sum('amount_toll');
        $totalCount = (clone $completed)->count();

        $daily = Donation::where('status', DonationStatus::COMPLETED)
            ->where('completed_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(completed_at) as date'),
                DB::raw('SUM(amount_money) / 100 as revenue'),
                DB::raw('SUM(amount_toll) as toll'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(completed_at)'))
            ->orderBy('date')
            ->get();

        $byGateway = Donation::where('status', DonationStatus::COMPLETED)
            ->select('gateway', DB::raw('SUM(amount_money) / 100 as revenue'), DB::raw('COUNT(*) as count'))
            ->groupBy('gateway')
            ->get();

        return response()->json([
            'total_revenue' => round($totalRevenue, 2),
            'total_toll' => $totalToll,
            'total_count' => $totalCount,
            'daily' => $daily,
            'by_gateway' => $byGateway,
        ]);
    }
}
