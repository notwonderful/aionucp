<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class PromoCode extends Model
{
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
}
