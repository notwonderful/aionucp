<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function getUsers(): LengthAwarePaginator
    {
        return User::paginate();
    }
}
