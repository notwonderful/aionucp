<?php

namespace App\Services;

use App\DataTransferObjects\UserData;
use Illuminate\Support\Facades\DB;

class AionAccountService
{
    public function create(UserData $userData): int
    {
        return DB::connection('aiondb')
            ->table('account_data')
            ->insertGetId([
                'name' => $userData->name,
                'email' => $userData->email,
                'password' => base64_encode(sha1($userData->password, true)),
            ]);
    }
}
