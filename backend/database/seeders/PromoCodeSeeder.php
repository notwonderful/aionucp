<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Database\Seeder;

final class PromoCodeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $users->each(function (User $user) {
            PromoCode::factory()->count(2)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
