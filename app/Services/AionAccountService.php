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
}
