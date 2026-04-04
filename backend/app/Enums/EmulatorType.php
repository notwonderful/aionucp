<?php

declare(strict_types=1);

namespace App\Enums;

enum EmulatorType: string
{
    case AION_EMU = 'AionEmu';

    public function getDefaultEncryptionType(): EncryptionType
    {
        return match ($this) {
            self::AION_EMU => EncryptionType::SHA1,
        };
    }

    public function getDisplayName(): string
    {
        return match ($this) {
            self::AION_EMU => 'Aion Emu',
        };
    }
}
