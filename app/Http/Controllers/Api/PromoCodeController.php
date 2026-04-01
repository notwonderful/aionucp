<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\GetPromoCodeData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeActivateRequest;
use App\Http\Requests\PromoCodeRequest;
use App\Http\Resources\PromoCodeResource;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class PromoCodeController extends Controller
{
    public function index(Request $request, GetPromoCodeData $getPromoCodeData): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $promoCodes = $getPromoCodeData->execute($user);

        return response()->json([
            'data' => PromoCodeResource::collection($promoCodes),
        ]);
    }

    public function store(PromoCodeRequest $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $promoCode = DB::transaction(function () use ($request, $user) {
            /** @var int|float $toll */
            $toll = $request->toll;
            $user->decrement('balance', $toll);

            return PromoCode::query()->create($request->validated());
        });

        return response()->json([
            'data' => new PromoCodeResource($promoCode),
            'message' => __('Promo code successfully created!'),
        ], 201);
    }

    public function activate(PromoCodeActivateRequest $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        DB::transaction(function () use ($request, $user) {
            $promoCode = PromoCode::query()
                ->where('code', $request->validated())
                ->lockForUpdate()
                ->firstOrFail();

            $user->increment('balance', $promoCode->toll);
            $promoCode->delete();
        });

        return response()->json([
            'message' => __('Promo Code successfully activated!'),
        ]);
    }
}
