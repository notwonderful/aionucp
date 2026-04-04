<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Http\Requests\PromoCodeRequest;

final readonly class CreatePromoCodeData
{
    public function __construct(
        public string $code,
        public int $toll,
        public int $userId,
    ) {}

    public static function fromRequest(PromoCodeRequest $request): self
    {
        /** @var array{code: string, toll: int|string, user_id: int|string} $data */
        $data = $request->validated();

        return new self(
            $data['code'],
            (int) $data['toll'],
            (int) $data['user_id'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'toll' => $this->toll,
            'user_id' => $this->userId,
        ];
    }
}
