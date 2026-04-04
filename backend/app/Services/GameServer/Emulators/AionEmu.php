<?php

declare(strict_types=1);

namespace App\Services\GameServer\Emulators;

use App\Services\GameServer\BaseGameServer;

final class AionEmu extends BaseGameServer
{
    protected function hashPassword(string $password): string
    {
        return $this->encrypter->encrypt($password);
    }
}
