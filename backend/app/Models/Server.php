<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ServerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Server extends Model
{
    /** @use HasFactory<ServerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'sort',
        'options',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'encrypted:array',
            'status' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    /** @param Builder<Server> $query */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', true);
    }
}
