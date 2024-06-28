<?php

namespace App\Http\Controllers;

use App\Actions\Game\GetAccountPlayers;
use App\Actions\Game\Player\TeleportPlayer;
use App\Models\Game\Player;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function create(GetAccountPlayers $getAccountPlayers): View
    {
        $accountInfo = $getAccountPlayers->execute(auth()->user()->aion_acc_id);

        return view('dashboard', compact('accountInfo'));
    }

    public function teleport(Player $player, TeleportPlayer $teleportPlayer)
    {
        $teleportPlayer->execute($player);

        return redirect()->back()->with('success', __('The player was successfully teleported!'));
    }
}
