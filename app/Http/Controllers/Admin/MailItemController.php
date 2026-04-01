<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Game\SendMailItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MailItemRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class MailItemController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.mail-item');
    }

    public function store(MailItemRequest $request, SendMailItemAction $sendMailItemAction): RedirectResponse
    {
        $sendMailItemAction->execute($request);

        return back()->with('success', __('The item has been successfully sent by mail!'));
    }
}
