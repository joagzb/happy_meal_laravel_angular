<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class notifyOrderFinished implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ORDERS_BROKER_WEBHOOK_ORDER_READY_URL;
    private $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->ORDERS_BROKER_WEBHOOK_ORDER_READY_URL = (string) env('ORDERS_BROKER_WEBHOOK_ORDER_READY_URL', 'http://localhost:8000/webhook/orders/:id/ready');

        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $webhookUrl = str_replace(':id', $this->order->id, $this->ORDERS_BROKER_WEBHOOK_ORDER_READY_URL);
        $response = Http::post($webhookUrl, [
            "order" => $this->order->with('dish')->first()
        ]);
        if ($response->successful()) {
            Log::info("ready Order webhook SENT for order " . $this->order->id . " to " . $webhookUrl);
        } else {
            Log::error("ready Order webhook FAILED for order " . $this->order->id);
            // retry sending the webhook up to 3 times
            if ($this->attempts() <= 3) {
                Log::warn("Order ready webhook FAILED for order " . $this->order->id . ". retrying...");
                $this->release(3); //delay 3 seconds and try again
            } else {
                Log::error("Order ready webhook FAILED for order " . $this->order->id . ". Reached max attempts " . $this->attempts());
            }
        }
    }
}
