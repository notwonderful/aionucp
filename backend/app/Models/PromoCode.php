<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PromoCodeRestriction;
use App\Enums\PromoCodeType;
use Database\Factories\PromoCodeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class PromoCode extends Model
{
    /** @use HasFactory<PromoCodeFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'type_restriction',
        'user_id',
        'users',
        'toll',
        'date_start',
        'date_end',
        'items',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => PromoCodeType::class,
            'type_restriction' => PromoCodeRestriction::class,
        ];
    }
}
