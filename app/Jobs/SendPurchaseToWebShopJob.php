<?php

namespace App\Jobs;

use App\Models\Game\Player;
use App\Models\Product;
use App\Services\WebShopService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPurchaseToWebShopJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Player $player,
        private readonly Product $product
    ) {}

    public function handle(WebShopService $webShopService): void
    {
        $webShopService->createWebShopItem($this->player, $this->product);
    }
}
