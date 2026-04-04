<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServerRequest;
use App\Http\Resources\ServerResource;
use App\Models\Server;
use App\Services\GameServer\ServerCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ServerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $servers = Server::query()->orderBy('sort')->paginate();

        return ServerResource::collection($servers);
    }

    public function store(ServerRequest $request, ServerCacheService $cacheService): JsonResponse
    {
        $server = Server::create([
            'name' => $request->validated('name'),
            'status' => $request->boolean('status', true),
            'sort' => $request->integer('sort', 0),
            'is_default' => $request->boolean('is_default'),
            'options' => $this->buildOptions($request),
        ]);

        $cacheService->flush();

        return response()->json([
            'data' => new ServerResource($server),
            'message' => __('Server created successfully.'),
        ], 201);
    }

    public function show(Server $server): ServerResource
    {
        return new ServerResource($server);
    }

    public function update(ServerRequest $request, Server $server, ServerCacheService $cacheService): JsonResponse
    {
        $server->update([
            'name' => $request->validated('name'),
            'status' => $request->boolean('status', true),
            'sort' => $request->integer('sort'),
            'is_default' => $request->boolean('is_default'),
            'options' => $this->buildOptions($request),
        ]);

        $cacheService->flush();

        return response()->json([
            'data' => new ServerResource($server),
            'message' => __('Server updated successfully.'),
        ]);
    }

    public function destroy(Server $server, ServerCacheService $cacheService): JsonResponse
    {
        $server->delete();

        $cacheService->flush();

        return response()->json(status: 204);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildOptions(ServerRequest $request): array
    {
        return [
            'emulator_type' => $request->validated('emulator_type'),
            'encryption_type' => $request->validated('encryption_type'),
            'db_driver' => $request->validated('db_driver') ?? 'mysql',
            'db_host' => $request->validated('db_host'),
            'db_port' => $request->validated('db_port'),
            'db_database' => $request->validated('db_database'),
            'db_username' => $request->validated('db_username'),
            'db_password' => $request->validated('db_password'),
        ];
    }
}
