<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Game\SendMailItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MailItemRequest;
use Illuminate\Http\JsonResponse;

final class MailItemController extends Controller
{
    public function store(MailItemRequest $request, SendMailItemAction $sendMailItemAction): JsonResponse
    {
        /** @var string $name */
        $name = $request->validated('name');
        /** @var int $itemId */
        $itemId = $request->validated('item_id');
        /** @var int $itemQty */
        $itemQty = $request->validated('item_qty');

        $sendMailItemAction->execute($name, $itemId, $itemQty);

        return response()->json([
            'message' => __('The item has been successfully sent by mail!'),
        ]);
    }
}
