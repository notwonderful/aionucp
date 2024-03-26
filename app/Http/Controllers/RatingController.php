<?php

namespace App\Http\Controllers;

use App\Actions\Game\GetAbyssRanks;
use Illuminate\View\View;

class RatingController extends Controller
{
    public function abyss(GetAbyssRanks $getAbyssRanks): View
    {
        $abyssRanks = $getAbyssRanks->execute();

        return view('pages.rating.abyss', compact('abyssRanks'));
    }
}
