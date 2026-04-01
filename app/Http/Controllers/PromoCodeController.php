<?php

namespace App\Http\Controllers;

use App\Actions\GetPromoCodeData;
use App\Http\Requests\PromoCodeActivateRequest;
use App\Http\Requests\PromoCodeRequest;
use App\Models\PromoCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetPromoCodeData $getPromoCodeData): View
    {
        $user = auth()->user();
        assert($user instanceof \App\Models\User);

        $promoCodes = $getPromoCodeData->execute($user);

        return view('pages.promocode.index', compact('promoCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.promocode.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromoCodeRequest $request): RedirectResponse
    {
        $user = auth()->user();
        assert($user instanceof \App\Models\User);

        /** @var int|float $toll */
        $toll = $request->toll;
        $user->decrement('balance', $toll);

        PromoCode::query()->create($request->validated());

        return back()->with('status', __('Promo code successfully updated!'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromoCodeRequest $request, PromoCode $promoCode): RedirectResponse
    {
        $promoCode->update($request->validated());

        return back()->with('status', __('Promo code successfully updated!'));
    }


    public function activate(PromoCodeActivateRequest $request): RedirectResponse
    {
        $promoCode = PromoCode::query()
            ->where('code', $request->validated())
            ->first();

        assert($promoCode instanceof PromoCode);

        $promoCode->delete();

        $user = auth()->user();
        assert($user instanceof \App\Models\User);

        $user->increment('balance', $promoCode->toll);

        return back()->with('success', __('Promo Code successfully activated!'));
    }
}
