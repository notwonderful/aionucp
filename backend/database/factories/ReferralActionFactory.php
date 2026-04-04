<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Referral;
use App\Models\ReferralAction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReferralAction>
 */
final class ReferralActionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'referral_id' => Referral::factory(),
            'aion_acc_id' => $this->faker->numberBetween(1, 100000),
            'action' => 'register',
        ];
    }
}
