<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

final class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => ['en' => 'General', 'ru' => 'Общие вопросы'], 'sort_order' => 1],
            ['name' => ['en' => 'Shop & Purchases', 'ru' => 'Магазин и покупки'], 'sort_order' => 2],
            ['name' => ['en' => 'Technical Issue', 'ru' => 'Техническая проблема'], 'sort_order' => 3],
            ['name' => ['en' => 'Account & Security', 'ru' => 'Аккаунт и безопасность'], 'sort_order' => 4],
            ['name' => ['en' => 'Report a Player', 'ru' => 'Жалоба на игрока'], 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            TicketCategory::create($category);
        }
    }
}
