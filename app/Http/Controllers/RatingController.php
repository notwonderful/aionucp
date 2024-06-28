<?php

namespace App\Http\Controllers;

use App\Actions\Game\GetAbyssRanks;
use App\Actions\Game\GetLegions;
use Illuminate\View\View;

final class RatingController extends Controller
{
    public function abyss(GetAbyssRanks $getAbyssRanks): View
    {
        $abyssRanks = $getAbyssRanks->execute();

        return view('pages.rating.abyss', compact('abyssRanks'));
    }

    public function legion(GetLegions $getLegions): View
    {
        $legions = $getLegions->execute();

        return view('pages.rating.legion', compact('legions'));
    }
}
