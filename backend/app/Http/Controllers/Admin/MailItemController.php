<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Game\SendMailItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MailItemRequest;
use App\Http\Resources\MailItemLogResource;
use App\Models\MailItemLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

final class MailItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $logs = MailItemLog::with('admin:id,name')
            ->latest()
            ->paginate();

        return MailItemLogResource::collection($logs);
    }

    public function store(MailItemRequest $request, SendMailItemAction $sendMailItemAction): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $lockKey = "mail_item_send:{$user->id}:{$request->validated('player_name')}:{$request->validated('item_id')}";

        $lock = Cache::lock($lockKey, 10);

        if (! $lock->get()) {
            return response()->json([
                'message' => __('Please wait, your previous request is still processing.'),
            ], 429);
        }

        try {
            $sendMailItemAction->execute(
                $request->validated('player_name'),
                (int) $request->validated('item_id'),
                (int) $request->validated('item_qty'),
                $user->id,
            );

            return response()->json([
                'message' => __('The item has been successfully sent by mail!'),
            ]);
        } finally {
            $lock->release();
        }
    }
}
