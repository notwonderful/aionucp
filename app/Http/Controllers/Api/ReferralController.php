<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\GetReferralData;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReferralResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ReferralController extends Controller
{
    public function index(Request $request, GetReferralData $getReferralData): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $referral = $getReferralData->execute($user);

        return response()->json([
            'data' => $referral ? new ReferralResource($referral) : null,
        ]);
    }
}
