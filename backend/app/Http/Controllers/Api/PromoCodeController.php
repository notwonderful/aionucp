<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\ActivatePromoCodeAction;
use App\Actions\CreatePromoCodeAction;
use App\DataTransferObjects\CreatePromoCodeData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeActivateRequest;
use App\Http\Requests\PromoCodeRequest;
use App\Http\Resources\PromoCodeResource;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PromoCodeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $promoCodes = PromoCode::query()
            ->where('user_id', $user->id)
            ->latest()
            ->paginate();

        return response()->json([
            'data' => PromoCodeResource::collection($promoCodes),
        ]);
    }

    public function store(PromoCodeRequest $request, CreatePromoCodeAction $createPromoCodeAction): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $promoCode = $createPromoCodeAction->execute($user, CreatePromoCodeData::fromRequest($request));

        return response()->json([
            'data' => new PromoCodeResource($promoCode),
            'message' => __('Promo code successfully created!'),
        ], 201);
    }

    public function activate(PromoCodeActivateRequest $request, ActivatePromoCodeAction $activatePromoCodeAction): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        /** @var string $code */
        $code = $request->validated('code');
        $activatePromoCodeAction->execute($user, $code);

        return response()->json([
            'message' => __('Promo Code successfully activated!'),
        ]);
    }
}
