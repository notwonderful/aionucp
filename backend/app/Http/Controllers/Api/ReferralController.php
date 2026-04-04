<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReferralResource;
use App\Models\User;
use App\Services\ReferralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ReferralController extends Controller
{
    public function index(Request $request, ReferralService $referralService): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $referral = $referralService->getReferralAccountInfo($user);

        return response()->json([
            'data' => $referral ? new ReferralResource($referral) : null,
        ]);
    }
}
