<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Game\MembershipPurchaseAction;
use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipRequest;
use App\Models\Game\AccountData;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class MembershipController extends Controller
{
    public function store(MembershipRequest $request, MembershipPurchaseAction $membershipPurchaseAction): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $account = AccountData::findOrFail($user->aion_acc_id);

        $membershipType = MembershipType::from($request->integer('membership_type'));
        $duration = MembershipDuration::from($request->integer('duration'));

        $membershipPurchaseAction->execute($account, $membershipType, $duration);

        return response()->json([
            'message' => __('Membership successfully purchased!'),
        ]);
    }
}
