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
        /** @var array{name: string, email: string, password: string} $data */
        $data = $request->validated();

        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
        );
    }
}
