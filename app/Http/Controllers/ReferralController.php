<?php

namespace App\Http\Controllers;

use App\Actions\GetReferralData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ReferralController extends Controller
{
    public function index(GetReferralData $getReferralData): View
    {
        $referral = $getReferralData->execute(auth()->user());

        return view('pages.referral.index', compact('referral'));
    }

    public function setReferralSession(string $ref_code): RedirectResponse
    {
        session()->put('ref_code', $ref_code);

        return redirect(route('register'));
    }
}
