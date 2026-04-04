<?php

declare(strict_types=1);

namespace App\Services\GameServer;

use App\Contracts\GameServerContract;
use App\Contracts\PasswordEncrypterContract;
use App\DataTransferObjects\UserData;
use App\Exceptions\InsufficientBalanceException;
use App\Models\Game\AbyssRank;
use App\Models\Game\BaseGameModel;
use App\Models\Game\AccountData;
use App\Models\Game\Inventory;
use App\Models\Game\Legion;
use App\Models\Game\MailItem;
use App\Models\Game\Player;
use App\Models\Server;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class BaseGameServer implements GameServerContract
{
    public function __construct(
        protected GameServerManager $manager,
        protected Server $server,
        protected PasswordEncrypterContract $encrypter
    ) {}

    abstract protected function hashPassword(string $password): string;

    public function getServerId(): int
    {
        return $this->server->id;
    }

    protected function connection(): ConnectionInterface
    {
        return $this->manager->getConnection($this->server);
    }

    protected function worldConnection(): ConnectionInterface
    {
        return DB::connection($this->worldConnectionName());
    }

    protected function connectionName(): string
    {
        return $this->manager->connectionName($this->server);
    }

    protected function worldConnectionName(): string
    {
        return $this->manager->worldConnectionName($this->server);
    }

    /**
     * @template TModel of Model
     *
     * @param  class-string<TModel>  $model
     * @return Builder<TModel>
     */
    protected function query(string $model): Builder
    {
        $connection = is_a($model, BaseGameModel::class, true) && $model::usesWorldDatabase()
            ? $this->worldConnectionName()
            : $this->connectionName();

        /** @var Builder<TModel> */
        return $model::on($connection);
    }

    protected function cacheKey(string $key): string
    {
        return "server_{$this->server->id}_{$key}";
    }

    public function createAccount(UserData $userData): int
    {
        return $this->query(AccountData::class)->insertGetId([
            'name' => $userData->name,
            'password' => $this->hashPassword($userData->password),
        ]);
    }

    public function updatePassword(int $accountId, string $password): void
    {
        $this->query(AccountData::class)
            ->where('id', $accountId)
            ->update(['password' => $this->hashPassword($password)]);
    }

    public function updateEmail(int $accountId, string $email): void
    {
        $this->query(AccountData::class)
            ->where('id', $accountId)
            ->update(['email' => $email]);
    }

    public function banAccount(string $name): int
    {
        return $this->query(AccountData::class)
            ->where('name', $name)
            ->update(['ip_force' => 1]);
    }

    public function unbanAccount(string $name): int
    {
        return $this->query(AccountData::class)
            ->where('name', $name)
            ->update(['ip_force' => null]);
    }

    public function getBalance(int $accountId): int
    {
        /** @var int $balance */
        $balance = Cache::flexible($this->cacheKey("balance_{$accountId}"), [60, 300], function () use ($accountId): int {
            /** @var int|null $toll */
            $toll = $this->query(AccountData::class)
                ->where('id', $accountId)
                ->value('toll');

            return $toll ?? 0;
        });

        return $balance;
    }

    public function setBalance(int $accountId, int $amount): void
    {
        $this->connection()->transaction(function () use ($accountId, $amount) {
            $this->query(AccountData::class)
                ->where('id', $accountId)
                ->lockForUpdate()
                ->first();

            $this->query(AccountData::class)
                ->updateOrInsert(['id' => $accountId], ['toll' => $amount]);
        });

        Cache::forget($this->cacheKey("balance_{$accountId}"));
    }

    public function decrementBalance(int $accountId, int $amount): void
    {
        $this->query(AccountData::class)
            ->where('id', $accountId)
            ->decrement('toll', $amount);

        Cache::forget($this->cacheKey("balance_{$accountId}"));
    }

    public function incrementBalance(int $accountId, int $amount): void
    {
        $this->query(AccountData::class)
            ->where('id', $accountId)
            ->increment('toll', $amount);

        Cache::forget($this->cacheKey("balance_{$accountId}"));
    }

    public function ensureSufficientBalance(int $accountId, int $requiredAmount): void
    {
        /** @var int|null $currentBalance */
        $currentBalance = $this->query(AccountData::class)
            ->where('id', $accountId)
            ->lockForUpdate()
            ->value('toll');

        if (($currentBalance ?? 0) < $requiredAmount) {
            throw new InsufficientBalanceException;
        }
    }

    /** @return LengthAwarePaginator<int, AccountData> */
    public function getAccountWithPlayers(int $accountId): LengthAwarePaginator
    {
        return Cache::flexible($this->cacheKey("account_{$accountId}_players"), [120, 600], function () use ($accountId) {
            $accounts = $this->query(AccountData::class)
                ->where('id', $accountId)
                ->paginate();

            $playersByAccount = $this->query(Player::class)
                ->whereIn('account_id', $accounts->pluck('id'))
                ->get()
                ->groupBy('account_id');

            $accounts->each(fn (AccountData $account) => $account->setRelation('players', $playersByAccount->get($account->id, collect()))
            );

            return $accounts;
        });
    }

    /** @return Collection<int, Player> */
    public function getPlayersByAccountId(int $accountId): Collection
    {
        return $this->query(Player::class)
            ->where('account_id', $accountId)
            ->select(['id', 'name'])
            ->get();
    }

    public function getPlayerByAccountId(int $accountId, int $playerId): Player
    {
        /** @var Player */
        return $this->query(Player::class)
            ->where('account_id', $accountId)
            ->where('id', $playerId)
            ->firstOrFail();
    }

    public function teleportPlayer(int $accountId, int $playerId, float $x, float $y, float $z, int $map): bool
    {
        $updated = $this->query(Player::class)
            ->where('account_id', $accountId)
            ->where('id', $playerId)
            ->where('online', 0)
            ->update([
                'x' => $x,
                'y' => $y,
                'z' => $z,
                'world_id' => $map,
            ]);

        return $updated > 0;
    }

    // ──────────────────────────────────────────────
    // Mail & Items
    // ──────────────────────────────────────────────

    public function sendMailItem(string $playerName, int $itemId, int $itemQty): void
    {
        /** @var Player $player */
        $player = $this->query(Player::class)
            ->where('name', $playerName)
            ->firstOrFail();

        $this->worldConnection()->transaction(function () use ($player, $itemId, $itemQty) {
            $uniqueItemId = $this->generateAttachedItemId();

            $this->query(Inventory::class)->create([
                'item_unique_id' => $uniqueItemId,
                'item_id' => $itemId,
                'item_skin' => $itemId,
                'item_count' => $itemQty,
                'item_owner' => $player->id,
                'item_creator' => '',
                'item_location' => 127,
                'enchant' => 0,
                'authorize' => 0,
            ]);

            $this->query(MailItem::class)->create([
                'sender_name' => 'Admin',
                'mail_unique_id' => $this->generateUniqueMailId(),
                'mail_recipient_id' => $player->id,
                'mail_title' => __('Mail Item Service'),
                'mail_message' => __('Thank you for purchasing!'),
                'attached_item_id' => $uniqueItemId,
                'attached_item_count' => $itemQty,
                'attached_kinah_count' => 0,
                'express' => 1,
            ]);
        });
    }

    // ──────────────────────────────────────────────
    // Rankings
    // ──────────────────────────────────────────────

    /** @return LengthAwarePaginator<int, AbyssRank> */
    public function getAbyssRanks(): LengthAwarePaginator
    {
        return Cache::flexible($this->cacheKey('abyss_ranks'), [300, 900], function () {
            return $this->query(AbyssRank::class)
                ->with('player:id,name,race,player_class,online')
                ->orderByDesc('rank')
                ->paginate();
        });
    }

    /** @return LengthAwarePaginator<int, Legion> */
    public function getLegionRanks(): LengthAwarePaginator
    {
        return Cache::flexible($this->cacheKey('legion_ranks'), [300, 900], function () {
            return $this->query(Legion::class)
                ->select('name', 'level', 'rank_pos')
                ->orderBy('rank_pos')
                ->paginate();
        });
    }

    // ──────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────

    private function generateUniqueMailId(): int
    {
        /** @var int|null $maxId */
        $maxId = $this->query(MailItem::class)
            ->lockForUpdate()
            ->max('mail_unique_id');

        return ($maxId ?? 0) + 1;
    }

    private function generateAttachedItemId(): int
    {
        /** @var int|null $maxId */
        $maxId = $this->query(Inventory::class)
            ->lockForUpdate()
            ->max('item_unique_id');

        return ($maxId ?? 0) + 1;
    }
}
