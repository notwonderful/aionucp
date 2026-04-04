<?php

declare(strict_types=1);

namespace App\Services\GameServer;

use App\Contracts\GameServerContract;
use App\Enums\EmulatorType;
use App\Enums\EncryptionType;
use App\Models\Server;
use App\Services\Encryption\PasswordEncrypterFactory;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class GameServerManager
{
    /** @var array<int, GameServerContract> */
    private array $instances = [];

    /** @var array<string, bool> */
    private array $initializedConnections = [];

    public function __construct(
        private readonly ServerCacheService $serverCache,
        private readonly GameServerResolver $resolver,
        private readonly Request $request,
    ) {}

    public function server(int $serverId): GameServerContract
    {
        if (isset($this->instances[$serverId])) {
            return $this->instances[$serverId];
        }

        $server = $this->serverCache->getServer($serverId);

        if (! $server) {
            throw new RuntimeException("Game server [{$serverId}] not found or inactive.");
        }

        return $this->instances[$serverId] = $this->createGameServer($server);
    }

    public function current(): GameServerContract
    {
        $serverId = $this->request->header('X-Server-Id');

        if ($serverId !== null) {
            return $this->server((int) $serverId);
        }

        $default = $this->serverCache->getDefaultServer();

        if (! $default) {
            throw new RuntimeException('No active game servers configured.');
        }

        return $this->server($default->id);
    }

    public function getConnection(Server $server): ConnectionInterface
    {
        $connectionName = $this->connectionName($server);

        if (! isset($this->initializedConnections[$connectionName])) {
            $this->initializeConnection($server);
        }

        return DB::connection($connectionName);
    }

    public function connectionName(Server $server): string
    {
        return "aiondb_{$server->id}";
    }

    public function worldConnectionName(Server $server): string
    {
        return "aiondb_{$server->id}_world";
    }

    private function createGameServer(Server $server): GameServerContract
    {
        $this->initializeConnection($server);

        /** @var array<string, string> $options */
        $options = $server->options;

        $emulatorType = EmulatorType::from($options['emulator_type']);
        $encryptionType = EncryptionType::from($options['encryption_type'] ?? $emulatorType->getDefaultEncryptionType()->value);

        $encrypter = PasswordEncrypterFactory::create($encryptionType);

        $class = $this->resolver->resolve($emulatorType);

        return new $class($this, $server, $encrypter);
    }

    private function initializeConnection(Server $server): void
    {
        $connectionName = $this->connectionName($server);

        if (isset($this->initializedConnections[$connectionName])) {
            return;
        }

        /** @var array<string, string> $options */
        $options = $server->options;

        $baseConfig = [
            'driver' => $options['db_driver'] ?? 'mysql',
            'host' => $options['db_host'],
            'port' => $options['db_port'] ?? '3306',
            'username' => $options['db_username'],
            'password' => $options['db_password'],
            'charset' => $options['db_charset'] ?? 'utf8mb4',
            'collation' => $options['db_collation'] ?? 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'connect_timeout' => 3,
            'options' => [
                \PDO::ATTR_TIMEOUT => 5,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ],
        ];

        Config::set("database.connections.{$connectionName}", array_merge($baseConfig, [
            'database' => $options['db_database'],
        ]));

        $worldDatabase = $options['db_world_database']
            ?? str_replace('_auth', '_world', $options['db_database']);

        Config::set("database.connections.{$this->worldConnectionName($server)}", array_merge($baseConfig, [
            'database' => $worldDatabase,
        ]));

        $this->initializedConnections[$connectionName] = true;
    }
}
