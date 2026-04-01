<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailBulkMessage;
use App\Models\User;
use App\Services\EmailBulkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BulkEmailController extends Controller
{
    public function sendBulkEmail(Request $request, EmailBulkService $bulkEmailSender): JsonResponse
    {
        /** @var array<string, string> $validated */
        $validated = $request->validate([
            'email_content' => ['required', 'string'],
        ]);

        $users = User::get();

        $emailContent = $validated['email_content'];

        $bulkEmailSender->sendBulkEmail(
            new EmailBulkMessage($emailContent),
            $users
        );

        return response()->json([
            'message' => __('Emails successfully sent!'),
        ]);
    }
}
