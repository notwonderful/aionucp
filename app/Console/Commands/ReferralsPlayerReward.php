<?php

namespace App\Console\Commands;

use App\Models\Game\Player;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReferralsPlayerReward extends Command
{
    protected $signature = 'referral:player-reward';

    public function handle(): void
    {
        DB::transaction(function () {
            $referralIds = Referral::query()->whereNotNull('history')->pluck('id');
            $referralsToSave = [];

            foreach ($referralIds as $referralId) {
                $referral = Referral::with('user')->find($referralId);
                $history = json_decode($referral->history, true);
                $processedWowAccIds = json_decode($referral->processed_aion_acc_ids, true) ?? [];

                foreach ($history as $entry) {
                    if (isset($entry['aion_acc_id']) && !in_array($entry['aion_acc_id'], $processedWowAccIds)) {
                        $player = Player::query()
                            ->where('account_id', $entry['aion_acc_id'])
                            ->where('exp', '>=', (int) config('referral.invited_user_player_exp'))
                            ->first();

                        if ($player) {
                            $processedWowAccIds[] = $entry['aion_acc_id'];
                            $referral->processed_aion_acc_ids = json_encode($processedWowAccIds);
                            $referral->user->increment('balance', (int) config('referral.referrer_reward'));
                            $referral->increment('earned', (int) config('referral.referrer_reward'));
                            $referralsToSave[] = $referral;

                            $invitedUser = User::where('aion_acc_id', $player->account_id)->first();
                            $invitedUser->increment('balance', (int) config('referral.invited_user_reward'));

                            cache()->deleteMultiple([
                                'account_balance_'. $referral->user->id,
                                'account_balance_'. $invitedUser->id,
                            ]);
                            break;
                        }
                    }
                }
            }

            foreach ($referralsToSave as $referral) {
                $referral->save();
            }

            $this->info('Successfully executed!');
        });
    }
}
