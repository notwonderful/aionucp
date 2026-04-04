<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Http\Requests\Admin\UserRequest;

final readonly class AdminUpdateUserData
{
    public function __construct(
        public ?string $email,
        public ?int $balance,
    ) {}

    public static function fromRequest(UserRequest $request): self
    {
        /** @var array{email?: string, balance?: int|string|null} $data */
        $data = $request->validated();

        return new self(
            $data['email'] ?? null,
            isset($data['balance']) ? (int) $data['balance'] : null,
        );
    }
}
