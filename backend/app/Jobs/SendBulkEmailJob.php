<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\EmailBulkMessage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /** @var list<int> */
    public array $backoff = [1, 5, 10];

    /**
     * Create a new job instance.
     *
     * @param  iterable<User>  $users
     */
    public function __construct(
        private readonly EmailBulkMessage $emailBulkMessage,
        private readonly iterable $users
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->users as $user) {
            Mail::to($user->email)
                ->send(clone $this->emailBulkMessage);
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error('SendBulkEmailJob failed', [
            'exception' => $exception->getMessage(),
        ]);
    }
}
