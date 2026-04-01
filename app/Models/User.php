<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Models\Game\AccountData;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property UserRole $role
 * @property int $aion_acc_id
 */
final class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'aion_acc_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /** @return HasMany<Donate, $this> */
    public function donates(): HasMany
    {
        return $this->hasMany(
            related: Donate::class,
        );
    }

    /** @return HasMany<Referral, $this> */
    public function referrals(): HasMany
    {
        return $this->hasMany(
            related: Referral::class,
        );
    }

    public function getBalanceAttribute(): int
    {
        $cacheKey = "account_balance_{$this->id}";

        /** @var int $balance */
        $balance = Cache::remember($cacheKey, 900, function (): int {
            /** @var int|null $toll */
            $toll = AccountData::query()
                ->where('id', $this->aion_acc_id)
                ->value('toll');

            return $toll ?? 0;
        });

        return $balance;
    }

    /**
     * @param  array<string, mixed>  $extra
     * @return Builder<AccountData>|int
     */
    protected function decrement($column, $amount = 1, array $extra = []): Builder|int
    {
        if ($column === 'balance') {
            $balance = AccountData::where('id', $this->aion_acc_id)
                ->select('toll');

            $balance->decrement('toll', $amount);

            return $balance;
        }

        return parent::decrement($column, $amount, $extra);
    }

    /**
     * @param  array<string, mixed>  $extra
     * @return Builder<AccountData>|int
     */
    protected function increment($column, $amount = 1, array $extra = []): Builder|int
    {
        if ($column === 'balance') {
            $balance = AccountData::where('id', $this->aion_acc_id)
                ->select('toll');

            $balance->increment('toll', $amount);

            return $balance;
        }

        return parent::increment($column, $amount, $extra);
    }
}
