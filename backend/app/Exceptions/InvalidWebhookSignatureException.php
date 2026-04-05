<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class InvalidWebhookSignatureException extends HttpException
{
    public function __construct()
    {
        parent::__construct(403, 'Invalid webhook signature.');
    }
}
