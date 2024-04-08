<?php

namespace App\Services\Payments\Gateways\PayOp;

class PayOpAdapter
{
    public static function makeApiClient(): PayOpApiClient
    {
        return new PayOpApiClient(
            config('services.payop.key'),
            config('services.payop.secret'),
            PayOpApiClient::LANG_EN,
        );
    }
}
