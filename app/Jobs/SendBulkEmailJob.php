<?php

namespace App\Jobs;

use App\Mail\EmailBulkMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
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
}
