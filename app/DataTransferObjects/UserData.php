<?php

namespace App\DataTransferObjects;

use App\Http\Requests\Auth\RegisterRequest;

final readonly class UserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        );
    }
}
