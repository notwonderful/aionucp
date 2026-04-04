<?php

declare(strict_types=1);

namespace App\Services\Encryption;

use App\Contracts\PasswordEncrypterContract;
use App\Enums\EncryptionType;
use App\Services\Encryption\Strategies\Sha1Encrypter;

final readonly class PasswordEncrypterFactory
{
    public static function create(EncryptionType $type): PasswordEncrypterContract
    {
        return match ($type) {
            EncryptionType::SHA1 => new Sha1Encrypter,
        };
    }
}
