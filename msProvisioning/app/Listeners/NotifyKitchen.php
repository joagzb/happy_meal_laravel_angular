<?php

namespace App\Listeners;

use App\Events\IngredientPurchased;
use App\Http\DTOs\IngredientDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyKitchen
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(IngredientPurchased $event)
    {
        $webhookUrl = env('KITCHEN_MS_WEBHOOK_URL');
        $ingredientDTO = new IngredientDTO($event->ingredientName, $event->quantity, true);

        $ingredientsAvailable = [];
        $ingredientsAvailable[] = $ingredientDTO;

        Http::post($webhookUrl, [
            'ingredients' => $ingredientsAvailable,
        ]);
        Log::info("Notifying ingredient availability to kitchen: " . $event->ingredientName . " - " . $event->quantity);
    }
}
