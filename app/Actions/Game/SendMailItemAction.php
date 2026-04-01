<?php

namespace App\Actions\Game;

use App\Http\Requests\Admin\MailItemRequest;
use App\Services\MailItemService;

class SendMailItemAction
{
    public function __construct(
        protected MailItemService $mailItemService
    ) {}

    /**
     * @throws \Exception
     */
    public function execute(MailItemRequest $request): bool
    {
        /** @var string $name */
        $name = $request->validated('name');
        /** @var int $itemId */
        $itemId = $request->validated('item_id');
        /** @var int $itemQty */
        $itemQty = $request->validated('item_qty');

        return $this->mailItemService->sendMailItem($name, $itemId, $itemQty);
    }
}
