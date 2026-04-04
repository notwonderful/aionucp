<?php

declare(strict_types=1);

namespace App\Services\GameServer;

use App\Enums\EmulatorType;
use InvalidArgumentException;

final readonly class GameServerResolver
{
    /**
     * @return class-string<BaseGameServer>
     */
    public function resolve(EmulatorType $emulatorType): string
    {
        $class = __NAMESPACE__.'\\Emulators\\'.$emulatorType->value;

        if (! class_exists($class)) {
            throw new InvalidArgumentException("Game server emulator [{$emulatorType->value}] not found.");
        }

        /** @var class-string<BaseGameServer> */
        return $class;
    }
}
