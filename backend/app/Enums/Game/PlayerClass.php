<?php

declare(strict_types=1);

namespace App\Enums\Game;

enum PlayerClass: string
{
    case GLADIATOR = 'GLADIATOR';
    case TEMPLAR = 'TEMPLAR';
    case ASSASSIN = 'ASSASSIN';
    case RANGER = 'RANGER';
    case SORCERER = 'SORCERER';
    case SPIRIT_MASTER = 'SPIRITMASTER';
    case CLERIC = 'CLERIC';
    case CHANTER = 'CHANTER';
}
