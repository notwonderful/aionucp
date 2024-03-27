<?php

namespace App\Http\Controllers;

use App\Actions\Game\MembershipPurchaseAction;
use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use App\Http\Requests\MembershipRequest;
use App\Models\Game\AccountData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function create(): View
    {
        return view('pages.membership');
    }

    public function store(MembershipRequest $request, MembershipPurchaseAction $membershipPurchaseAction): RedirectResponse
    {
        $account = AccountData::findOrFail(auth()->user()->aion_acc_id);

        $membershipType = MembershipType::from($request->validated('membership_type'));
        $duration = MembershipDuration::from($request->validated('duration'));

        if (! $membershipPurchaseAction->execute($account, $membershipType, $duration)) {
            return redirect()->back()->withErrors(['balance' => __('Not enough balance to purchase')]);
        }

        return redirect()->route('membership')->with('success', __('Membership successfully purchased!'));
    }
}
