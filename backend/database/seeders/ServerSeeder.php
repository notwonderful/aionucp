<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

final class ServerSeeder extends Seeder
{
    public function run(): void
    {
        Server::factory()->default()->create([
            'name' => 'Main Server',
            'sort' => 0,
        ]);
    }
}
