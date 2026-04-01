<?php

namespace App\Http\Controllers;

use App\Actions\Game\GetAccountPlayers;
use App\Actions\Game\Player\TeleportPlayer;
use App\Models\Game\Player;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function create(GetAccountPlayers $getAccountPlayers): View
    {
        $user = auth()->user();
        assert($user instanceof User);

        $accountInfo = $getAccountPlayers->execute($user->aion_acc_id);

        return view('dashboard', compact('accountInfo'));
    }

    public function teleport(Player $player, TeleportPlayer $teleportPlayer): RedirectResponse
    {
        $user = auth()->user();
        assert($user instanceof User);

        if ($player->account_id !== $user->aion_acc_id) {
            abort(403);
        }

        $teleportPlayer->execute($player);

        return redirect()->back()->with('success', __('The player was successfully teleported!'));
    }
}
