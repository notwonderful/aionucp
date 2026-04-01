<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Game\Player;
use App\Models\Product;
use App\Services\WebShopService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendPurchaseToWebShopJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /** @var list<int> */
    public array $backoff = [1, 5, 10];

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Player $player,
        private readonly Product $product
    ) {}

    public function handle(WebShopService $webShopService): void
    {
        $webShopService->createWebShopItem(
            $this->player->withoutRelations(),
            $this->product->withoutRelations()
        );
    }

    public function failed(Throwable $exception): void
    {
        Log::error('SendPurchaseToWebShopJob failed', [
            'player_id' => $this->player->id,
            'product_id' => $this->product->id,
            'exception' => $exception->getMessage(),
        ]);
    }
}
