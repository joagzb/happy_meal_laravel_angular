<?php

namespace App\Jobs;

use App\Events\IngredientPurchased;
use App\Models\Ingredient;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PurchaseIngredient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $MARKET_API_URL;
    private $purchase;

    /**
     * Create a new job instance.
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
        $this->MARKET_API_URL = (string) env('MARKET_API_URL', 'https://recruitment.alegra.com/api/farmers-market/buy');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $quantitySold = $this->buy($this->purchase->ingredient->name);

        $this->purchase->updateStatusByQuantityReceived($quantitySold);

        $ingredient = Ingredient::where('name', $this->purchase->ingredient->name)->first();
        $ingredient->incrementStock($quantitySold);
        $ingredient = $ingredient->fresh();

        if ($this->purchase->isPurchaseCompleted()) {
            // notify the kitchen about the availability
            event(new IngredientPurchased($ingredient->name, $ingredient->quantity));
        } else if ($this->purchase->isPurchasePending()) {
            $this->purchase->updateStatusByBuyAttempts();
            $this->purchase = $this->purchase->fresh();
            $this->delay(2); //delay 2 seconds
            $this->dispatchAfterResponse($this->purchase);
        } else {
            Log::error("Failed to purchase ingredient: retry limit reached");
        }
    }

    private function buy(string $ingredientName): int
    {
        $quantitySold = 0;
        $response = Http::get($this->MARKET_API_URL, [
            'ingredient' => $ingredientName
        ]);
        if ($response->successful()) {
            $quantitySold = $response->json('quantitySold');
        } else {
            Log::error("Failed to purchase ingredient: {$ingredientName}");
        }

        return $quantitySold;
    }
}
