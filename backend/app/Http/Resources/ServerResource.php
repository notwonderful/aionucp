<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/** @mixin Server */
final class ServerResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var array<string, string> $options */
        $options = $this->options;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'sort' => $this->sort,
            'is_default' => $this->is_default,
            'emulator_type' => $options['emulator_type'] ?? null,
            'encryption_type' => $options['encryption_type'] ?? null,
            'db_host' => Str::mask($options['db_host'] ?? '', '*', 2, -2),
            'db_port' => $options['db_port'] ?? null,
            'db_database' => Str::mask($options['db_database'] ?? '', '*', 2, -2),
            'created_at' => $this->created_at,
        ];
    }
}
