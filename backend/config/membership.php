<?php

declare(strict_types=1);

return [
    'costs' => [
        'VIP' => env('MEMBERSHIP_COST_VIP', 100),
        'PREMIUM' => env('MEMBERSHIP_COST_PREMIUM', 200),
    ],
];
