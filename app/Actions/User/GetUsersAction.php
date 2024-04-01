<?php

namespace App\Actions\User;

use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;

class GetUsersAction
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function execute(): LengthAwarePaginator
    {
       return $this->userService->getUsers();
    }
}
