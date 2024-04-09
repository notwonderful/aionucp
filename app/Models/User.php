<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Models\Game\AccountData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'balance',
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

    public function donates(): HasMany
    {
        return $this->hasMany(
            related: Donate::class,
        );
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(
            related: Referral::class,
        );
    }

    public function getBalanceAttribute()
    {
        $cacheKey = "account_balance_{$this->id}";

        return Cache::remember($cacheKey, 900, function () {
            return AccountData::query()
                ->where('id', $this->aion_acc_id)
                ->value('toll') ?? 0;
        });
    }

    protected function decrement($column, $amount = 1, array $extra = []): Builder|AccountData|int|false
    {
        if ($column === 'balance') {
            $balance = AccountData::where('id', $this->aion_acc_id)
                ->select('toll');

            $balance->decrement('toll', $amount);

            return $balance;
        }

        return parent::decrement($column, $amount, $extra);
    }

    protected function increment($column, $amount = 1, array $extra = []): Builder|AccountData|int|false
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
