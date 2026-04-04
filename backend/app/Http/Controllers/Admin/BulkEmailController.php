<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendBulkEmailJob;
use App\Mail\EmailBulkMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BulkEmailController extends Controller
{
    public function sendBulkEmail(Request $request): JsonResponse
    {
        /** @var array<string, string> $validated */
        $validated = $request->validate([
            'email_content' => ['required', 'string'],
        ]);

        $emailContent = $validated['email_content'];

        User::query()->select(['id', 'email'])->chunk(100, function ($users) use ($emailContent) {
            SendBulkEmailJob::dispatch(
                new EmailBulkMessage($emailContent),
                $users
            );
        });

        return response()->json([
            'message' => __('Emails queued for sending!'),
        ]);
    }
}
