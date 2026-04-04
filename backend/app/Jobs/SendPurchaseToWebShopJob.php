<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Game\Player;
use App\Models\Game\WebShop;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

final class SendPurchaseToWebShopJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /** @var list<int> */
    public array $backoff = [1, 5, 10];

    public function __construct(
        private readonly Player $player,
        private readonly Product $product
    ) {}

    public function handle(): void
    {
        WebShop::create([
            'recipient' => $this->player->name,
            'item_desc' => $this->product->name,
            'item_id' => $this->product->item_id,
            'count' => $this->product->item_qty,
            'toll' => $this->product->toll,
            'balanced' => true,
            'send' => true,
            'shop_type' => 'PRODUCT',
            'time_received' => now(),
        ]);
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
