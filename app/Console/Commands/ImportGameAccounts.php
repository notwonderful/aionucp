<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportGameAccounts extends Command
{
    protected $signature = 'import:game-accounts';

    protected $description = 'Importing existing game accounts into a web database';

    public function handle(): void
    {
        DB::transaction(function () {
            DB::connection('aiondb')
                ->table('account_data')
                ->orderBy('id')
                ->chunkById(1000, function ($importAccounts) {
                    $userData = $importAccounts->map(function ($importAccount) {
                        return [
                            'name' => $importAccount->name,
                            'email' => strtolower($importAccount->email),
                            'email_verified_at' => now(),
                            'password' => Str::password(),
                            'aion_acc_id' => $importAccount->id,
                            'created_at' => $importAccount->created_at ?? now(),
                            'updated_at' => now(),
                        ];
                    })->toArray();

                    DB::table('users')
                        ->upsert(
                            $userData,
                            ['email'],
                            ['aion_acc_id', 'updated_at']
                        );

                    $this->info('Imported or updated ' . count($userData) . ' accounts');
                });
        });
    }
}
