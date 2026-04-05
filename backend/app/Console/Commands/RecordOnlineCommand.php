<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\GameServerContract;
use App\Models\OnlineSnapshot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

final class RecordOnlineCommand extends Command
{
    protected $signature = 'app:record-online';

    protected $description = 'Record current online player count and rebuild history cache';

    public function handle(GameServerContract $gameServer): void
    {
        $stats = $gameServer->getServerStats();

        OnlineSnapshot::create([
            'online_count' => $stats['online'],
            'recorded_at' => now(),
        ]);

        $this->rebuildCache();

        $this->info("Recorded online count: {$stats['online']}");
    }

    private function rebuildCache(): void
    {
        $since = now()->subDays(7);

        $daily = OnlineSnapshot::where('recorded_at', '>=', $since)
            ->selectRaw('DATE(recorded_at) as date, MAX(online_count) as peak, ROUND(AVG(online_count)) as avg')
            ->groupByRaw('DATE(recorded_at)')
            ->orderBy('date')
            ->get()
            ->map(fn ($row) => [
                'date' => $row->date,
                'peak' => (int) $row->peak,
                'avg' => (int) $row->avg,
            ]);

        $hourly = OnlineSnapshot::where('recorded_at', '>=', $since)
            ->selectRaw('HOUR(recorded_at) as hour, ROUND(AVG(online_count)) as avg')
            ->groupByRaw('HOUR(recorded_at)')
            ->orderBy('hour')
            ->get()
            ->map(fn ($row) => [
                'hour' => (int) $row->hour,
                'avg' => (int) $row->avg,
            ]);

        Cache::put('online_history', [
            'daily' => $daily,
            'hourly' => $hourly,
        ], now()->addHours(2));
    }
}
