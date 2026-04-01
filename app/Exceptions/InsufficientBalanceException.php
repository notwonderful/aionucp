<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('Insufficient balance.'));
    }
}
