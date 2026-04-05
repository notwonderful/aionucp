<?php

declare(strict_types=1);

namespace App\Services\GameServer;

use App\Contracts\GameServerContract;
use App\Enums\EmulatorType;
use App\Enums\EncryptionType;
use App\Services\Encryption\PasswordEncrypterFactory;

final class GameServerManager
{
    private ?GameServerContract $instance = null;

    public function __construct(
        private readonly GameServerResolver $resolver,
    ) {}

    public function current(): GameServerContract
    {
        if ($this->instance !== null) {
            return $this->instance;
        }

        $emulatorType = EmulatorType::from(config('game.emulator'));
        $encryptionType = EncryptionType::from(config('game.encryption') ?? $emulatorType->getDefaultEncryptionType()->value);
        $encrypter = PasswordEncrypterFactory::create($encryptionType);

        $class = $this->resolver->resolve($emulatorType);

        return $this->instance = new $class($this, $encrypter);
    }

    public function connectionName(): string
    {
        return 'aion_auth';
    }

    public function worldConnectionName(): string
    {
        return 'aion_world';
    }
}
