<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Game\SendMailItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MailItemRequest;
use App\Models\Game\MailItem;
use App\Models\Game\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MailItemController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.mail-item');
    }

    public function store(MailItemRequest $request, SendMailItemAction $sendMailItemAction): RedirectResponse
    {
        $success = $sendMailItemAction->execute($request);

        if ($success) {
            return back()->with('success', __('The item has been successfully sent by mail!'));
        }

        return back()->with('error', __('An error occurred while sending the item by mail.'));
    }
}
