<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DataTransferObjects\UserData;
use App\Exceptions\InsufficientBalanceException;
use App\Models\Game\AbyssRank;
use App\Models\Game\AccountData;
use App\Models\Game\Legion;
use App\Models\Game\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface GameServerContract
{
    // Account
    public function createAccount(UserData $userData): int;

    public function updatePassword(int $accountId, string $password): void;

    public function updateEmail(int $accountId, string $email): void;

    public function banAccount(string $name): int;

    public function unbanAccount(string $name): int;

    // Balance
    public function getBalance(int $accountId): int;

    public function setBalance(int $accountId, int $amount): void;

    public function decrementBalance(int $accountId, int $amount): void;

    public function incrementBalance(int $accountId, int $amount): void;

    /**
     * Acquire pessimistic lock and verify sufficient balance. Must be called inside a transaction.
     *
     * @throws InsufficientBalanceException
     */
    public function ensureSufficientBalance(int $accountId, int $requiredAmount): void;

    // Players
    /** @return LengthAwarePaginator<int, AccountData> */
    public function getAccountWithPlayers(int $accountId): LengthAwarePaginator;

    /** @return Collection<int, Player> */
    public function getPlayersByAccountId(int $accountId): Collection;

    public function getPlayerByAccountId(int $accountId, int $playerId): Player;

    public function teleportPlayer(int $accountId, int $playerId, float $x, float $y, float $z, int $map): bool;

    public function playerExists(string $name): bool;

    // Mail & Items
    public function sendMailItem(string $playerName, int $itemId, int $itemQty): void;

    // Rankings
    /** @return LengthAwarePaginator<int, AbyssRank> */
    public function getAbyssRanks(): LengthAwarePaginator;

    /** @return LengthAwarePaginator<int, Legion> */
    public function getLegionRanks(): LengthAwarePaginator;

    // Stats
    /** @return array{online: int, total_characters: int, races: array<string, int>, classes: array<string, int>} */
    public function getServerStats(): array;
}
