<?php

declare(strict_types=1);

namespace App\Services\Encryption\Strategies;

use App\Contracts\PasswordEncrypterContract;

final readonly class Sha1Encrypter implements PasswordEncrypterContract
{
    public function encrypt(string $password): string
    {
        return base64_encode(sha1($password, true));
    }
}
