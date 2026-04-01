<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /** @return LengthAwarePaginator<int, User> */
    public function getUsers(): LengthAwarePaginator
    {
        return User::paginate();
    }
}
