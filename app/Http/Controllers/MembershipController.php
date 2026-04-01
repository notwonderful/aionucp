<?php

namespace App\Http\Controllers;

use App\Actions\Game\MembershipPurchaseAction;
use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use App\Http\Requests\MembershipRequest;
use App\Models\Game\AccountData;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class MembershipController extends Controller
{
    public function create(): View
    {
        return view('pages.membership');
    }

    public function store(MembershipRequest $request, MembershipPurchaseAction $membershipPurchaseAction): RedirectResponse
    {
        $user = auth()->user();
        assert($user instanceof User);

        $account = AccountData::findOrFail($user->aion_acc_id);

        /** @var string $membershipTypeValue */
        $membershipTypeValue = $request->validated('membership_type');
        /** @var string $durationValue */
        $durationValue = $request->validated('duration');

        $membershipType = MembershipType::from($membershipTypeValue);
        $duration = MembershipDuration::from($durationValue);

        if (! $membershipPurchaseAction->execute($account, $membershipType, $duration)) {
            return redirect()->back()->withErrors(['balance' => __('Not enough balance to purchase')]);
        }

        return redirect()->route('membership')->with('success', __('Membership successfully purchased!'));
    }
}
