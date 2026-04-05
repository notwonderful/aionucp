<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ScheduleEntry;
use Illuminate\Database\Seeder;

final class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        ScheduleEntry::truncate();

        $now = now();
        $sort = 0;
        $rows = [];

        $sieges = [
            ['time' => '16:00', 'entries' => [
                [0, 'Asteria', 'lower'], [2, 'Asteria', 'lower'], [4, 'Asteria', 'lower'], [6, 'Asteria', 'lower'],
            ]],
            ['time' => '18:00', 'entries' => [
                [1, 'Sulfur', 'upper'], [3, 'Sulfur', 'upper'], [5, 'Sulfur', 'upper'],
            ]],
            ['time' => '20:00', 'entries' => [
                [0, 'Krotan', 'lower'], [1, 'Kysis', 'lower'], [2, 'Miren', 'lower'],
                [3, 'Krotan', 'lower'], [4, 'Kysis', 'lower'], [5, 'Miren', 'lower'], [6, 'Krotan', 'lower'],
            ]],
            ['time' => '22:00', 'entries' => [
                [5, 'Divine', 'divine'], [6, 'Divine', 'divine'],
            ]],
            ['time' => '23:00', 'entries' => [
                [0, 'Siel Western', 'upper'], [2, 'Siel Eastern', 'upper'],
                [4, 'Siel Western', 'upper'], [6, 'Siel Eastern', 'upper'],
            ]],
            ['time' => '00:00', 'entries' => [
                [5, 'Divine', 'divine'],
            ]],
        ];

        foreach ($sieges as $group) {
            foreach ($group['entries'] as [$day, $name, $type]) {
                $rows[] = [
                    'category' => 'siege',
                    'name' => $name,
                    'metadata' => json_encode(['time' => $group['time'], 'day_of_week' => $day, 'fortress_type' => $type]),
                    'sort_order' => $sort++,
                    'published' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        $dredgions = [
            ['Baranath Dredgion', 'Lv. 46-55', [['days' => 'Mon — Fri', 'time' => '10:00 — 02:00'], ['days' => 'Sat — Sun', 'time' => '10:00 — 02:00']]],
            ['Chantra Dredgion', 'Lv. 51-55', [['days' => 'Mon — Fri', 'time' => '12:00 — 02:00'], ['days' => 'Sat — Sun', 'time' => '12:00 — 02:00']]],
            ['Terath Dredgion', 'Lv. 55', [['days' => 'Sat', 'time' => '20:00 — 22:00'], ['days' => 'Sun', 'time' => '20:00 — 22:00']]],
        ];

        foreach ($dredgions as [$name, $level, $slots]) {
            $rows[] = [
                'category' => 'dredgion',
                'name' => $name,
                'metadata' => json_encode(['level' => $level, 'slots' => $slots]),
                'sort_order' => $sort++,
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $rifts = [
            ['01:00', 'Morheim → Eltnen'], ['03:00', 'Eltnen → Morheim'],
            ['05:00', 'Morheim → Eltnen'], ['07:00', 'Eltnen → Morheim'],
            ['09:00', 'Morheim → Eltnen'], ['11:00', 'Eltnen → Morheim'],
            ['13:00', 'Morheim → Eltnen'], ['15:00', 'Eltnen → Morheim'],
            ['17:00', 'Morheim → Eltnen'], ['19:00', 'Eltnen → Morheim'],
            ['21:00', 'Morheim → Eltnen'], ['23:00', 'Eltnen → Morheim'],
        ];

        foreach ($rifts as [$time, $direction]) {
            $rows[] = [
                'category' => 'rift',
                'name' => $direction,
                'metadata' => json_encode(['time' => $time, 'direction' => $direction]),
                'sort_order' => $sort++,
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        ScheduleEntry::insert($rows);
    }
}
