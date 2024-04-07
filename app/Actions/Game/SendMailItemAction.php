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
        return $this->mailItemService->sendMailItem(
            $request->validated('name'),
            $request->validated('item_id'),
            $request->validated('item_qty'),
        );
    }
}
