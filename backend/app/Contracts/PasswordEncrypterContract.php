<?php

declare(strict_types=1);

namespace App\Contracts;

interface PasswordEncrypterContract
{
    public function encrypt(string $password): string;
}
