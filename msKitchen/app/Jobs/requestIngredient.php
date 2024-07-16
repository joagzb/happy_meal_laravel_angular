<?php

namespace App\Jobs;

use App\Events\OrderReadyToCook;
use App\Http\Requests\IngredientsAvailableWebhookRequest;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class requestIngredient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $PROVISIONING_INGREDIENTS_REQUEST_URL;
    private $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->PROVISIONING_INGREDIENTS_REQUEST_URL = (string) env('PROVISIONING_INGREDIENTS_REQUEST_URL','http://localhost:8002/stock/ingredients');
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get ingredients for this dish
        $ingredientsNeeded = $this->order->dish->getIngredients();
        Log::info("Requesting ingredients for order " . $this->order->id . " having dish " . $this->order->dish->name . " : " . json_encode($ingredientsNeeded));

        // check wheter all the ingredients are available and start cooking
        $ingredientsAvailability = $this->fetchIngredients($ingredientsNeeded);
        if ($this->canCook($ingredientsAvailability)) {
            event(new OrderReadyToCook($this->order));
        } else {
            Log::info("No enough ingredients to prepare the order:" . $this->order->id . ".Waiting for ingredients availability notification");
        }
    }

    // check wheter all the ingredients are available
    private function canCook(array $ingredientsAvailability): bool
    {
        foreach ($ingredientsAvailability as $ingredient) {
            if (!$ingredient['availability']) {
                return false;
            }
        }

        return true;
    }

    private function fetchIngredients(array $ingredients): array{
        $response = Http::post($this->PROVISIONING_INGREDIENTS_REQUEST_URL,[
            'ingredients' => $ingredients
        ]);

        Log::debug("got response from provisioningMS for order " . $this->order->id . " : " . json_encode($response->json()));

        // Create a new instance of the request and validate the data
        $request = new IngredientsAvailableWebhookRequest();
        $validator = Validator::make($response->json('data'), $request->rules());

        if ($response->successful() && $validator->passes()) {
            return $validator->validated()['ingredients'];
        } else {
            Log::error("Failed to request ingredients. Status: " . $response->status() . " Response: " . $response->body() . "Validator: " . $validator->errors());
        }
    }
}
