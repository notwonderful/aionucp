<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailBulkMessage;
use App\Models\User;
use App\Services\EmailBulkService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BulkEmailController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.bulk-email');
    }

    public function sendBulkEmail(Request $request, EmailBulkService $bulkEmailSender): RedirectResponse
    {
        $request->validate([
            'email_content' => ['required', 'string']
        ]);

        $users = User::get();

        $bulkEmailSender->sendBulkEmail(
            new EmailBulkMessage($request->email_content),
            $users
        );

        return back()->with('status', __('Emails successfully sent!'));
    }
}
