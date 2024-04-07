<?php

namespace App\Services;

use App\DataTransferObjects\UserData;
use App\Models\Game\AccountData;
use Illuminate\Support\Facades\Cache;

class AionAccountService
{
    public function create(UserData $userData): int
    {
        return AccountData::query()->insertGetId([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => base64_encode(sha1($userData->password, true)),
        ]);
    }

    public function updatePassword(int $aionAccountId, string $password): void
    {
        AccountData::query()
            ->where('id', $aionAccountId)
            ->update([
                'password' => base64_encode(sha1($password, true)),
            ]);
    }

    public function updateEmail(int $aionAccountId, string $email): void
    {
        AccountData::query()
            ->where('id', $aionAccountId)
            ->update([
                'email' => $email,
            ]);
    }

    public function getAccountBalance(int $userId)
    {
        $cacheKey = "account_balance_{$userId}";

        return Cache::remember($cacheKey, 900, function () use ($userId) {
            return AccountData::query()
                ->where('id', $userId)
                ->select('toll')
                ->value('toll') ?? 0;
        });
    }

    public function decrementAccountBalance(int $userId, int $amount): void
    {
        $cacheKey = "account_balance_{$userId}";

        Cache::increment($cacheKey, -$amount);

        AccountData::query()
            ->where('id', $userId)
            ->decrement('toll', $amount);
    }

    public function setAccountBalance(int $userId, int $amount): void
    {
        AccountData::updateOrCreate(
            ['id' => $userId],
            ['toll' => $amount]
        );
    }

    public function getAccountPlayers(int $userId)
    {
        return Cache::remember("account_{$userId}_players", 300, function () use ($userId) {
            return AccountData::with('players')
                ->where('id', $userId)
                ->paginate();
        });
    }

    public function banAccount(string $name): int
    {
        return AccountData::query()
            ->where('name', $name)
            ->select('ip_force')
            ->update([
               'ip_force' => 1,
            ]);
    }

    public function unbanAccount(string $name): int
    {
        return AccountData::query()
            ->where('name', $name)
            ->select('ip_force')
            ->update([
                'ip_force' => null,
            ]);
    }
}
