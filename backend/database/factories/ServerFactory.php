<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\EmulatorType;
use App\Enums\EncryptionType;
use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Server>
 */
final class ServerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word().' Server',
            'status' => true,
            'sort' => 0,
            'is_default' => false,
            'options' => [
                'emulator_type' => EmulatorType::AION_EMU->value,
                'encryption_type' => EncryptionType::SHA1->value,
                'db_driver' => 'mysql',
                'db_host' => 'mysql-8.0',
                'db_port' => '3306',
                'db_database' => 'aion_beyond_auth',
                'db_world_database' => 'aion_beyond_world',
                'db_username' => 'root',
                'db_password' => '',
            ],
        ];
    }

    public function default(): static
    {
        return $this->state(fn () => [
            'is_default' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => false,
        ]);
    }
}
