<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ProductSeeder::class,
            PromoCodeSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ])->assignRole(UserRole::SUPER_ADMIN);

        User::factory()->create([
            'name' => 'testuser',
            'email' => 'user@example.com',
        ])->assignRole(UserRole::MEMBER);
    }
}
