<?php

declare(strict_types=1);

namespace App\Services\GameServer;

use App\Models\Server;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class ServerCacheService
{
    private const int CACHE_TTL = 600;

    private const string CACHE_KEY = 'active_servers';

    /** @var Collection<int, Server>|null */
    private ?Collection $requestCache = null;

    /** @return Collection<int, Server> */
    public function getActiveServers(): Collection
    {
        if ($this->requestCache !== null) {
            return $this->requestCache;
        }

        /** @var Collection<int, Server> $servers */
        $servers = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Server::query()->active()->orderBy('sort')->get();
        });

        $this->requestCache = $servers;

        return $servers;
    }

    public function getServer(int $id): ?Server
    {
        return $this->getActiveServers()->firstWhere('id', $id);
    }

    public function getDefaultServer(): ?Server
    {
        return $this->getActiveServers()->firstWhere('is_default', true)
            ?? $this->getActiveServers()->first();
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        $this->requestCache = null;
    }
}
