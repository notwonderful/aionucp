<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Http\Requests\ProfileUpdateRequest;

final readonly class ProfileUpdateData
{
    public function __construct(
        public string $email,
    ) {}

    public static function fromRequest(ProfileUpdateRequest $request): self
    {
        /** @var array{email: string} $data */
        $data = $request->validated();

        return new self($data['email']);
    }
}
