<?php

declare(strict_types=1);

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
    public function execute(MailItemRequest $request): void
    {
        /** @var string $name */
        $name = $request->validated('name');
        /** @var int $itemId */
        $itemId = $request->validated('item_id');
        /** @var int $itemQty */
        $itemQty = $request->validated('item_qty');

        $this->mailItemService->sendMailItem($name, $itemId, $itemQty);
    }
}
