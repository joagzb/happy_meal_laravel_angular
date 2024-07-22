<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use App\Events\OrderFinished;
use App\Events\OrderReadyToCook;
use App\Events\OrderReceived;
use App\Jobs\requestIngredient;
use App\OrderStatusEnum;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Sleep;

class OrdersListener implements OrderStatusHandler
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderEvent $event): void
    {
        switch ($event) {
            case $event instanceof OrderReceived:
                $this->handleOrderReceived($event);
                break;
            case $event instanceof OrderFinished:
                $this->handleOrderFinished($event);
                break;
            case $event instanceof OrderReadyToCook:
                $this->handleOrderReadyToCook($event);
                break;
        }
    }

    public function handleOrderReceived(OrderReceived $event): void
    {
        $orderReceived = $event->getOrder();
        Log::info("order received: " . $orderReceived->id . " with dish: " . $orderReceived->dish->name);

        requestIngredient::dispatch($orderReceived)->onQueue('orders');
    }

    public function handleOrderReadyToCook(OrderReadyToCook $event): void
    {
        $order = $event->getOrder();
        $order->status = OrderStatusEnum::COOKING;
        $order->save();

        Log::debug("order ready to cook: " . $order->id . " with dish: " . $order->dish->name);

        // simulate cooking
        Sleep::for(5)->seconds();

        event(new OrderFinished($order));
    }

    public function handleOrderFinished(OrderFinished $event): void
    {
        $order = $event->getOrder();
        $order->status = OrderStatusEnum::COMPLETED;
        $order->save();

        Log::debug("order finished: " . $order->id . " with dish: " . $order->dish->name);
        $ORDERS_BROKER_WEBHOOK_ORDER_READY_URL = (string) env('ORDERS_BROKER_WEBHOOK_ORDER_READY_URL', 'http://localhost:8000/webhook/orders/:id/ready');
        $webhookUrl = str_replace(':id', $order->id, $ORDERS_BROKER_WEBHOOK_ORDER_READY_URL);

        $response = Http::post($webhookUrl, [
            "order" => $order->with('dish')->first()
        ]);

        if ($response->successful()) {
            Log::info("ready Order webhook SENT for order " . $order->id . " to " . $webhookUrl);
        } else {
            Log::warn("Order ready webhook FAILED for order " . $order->id . ". retrying...");
            event(new OrderFinished($order));
        }
    }
}
