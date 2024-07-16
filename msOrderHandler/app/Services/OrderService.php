<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OrderService
{
    private $KITCHEN_MS_BASE_URL;

    public function __construct()
    {
        $this->KITCHEN_MS_BASE_URL = (string) env('KITCHEN_MS_BASE_URL');
    }

    public function getOrders()
    {
        $response = Http::get($this->KITCHEN_MS_BASE_URL . '/kitchen/orders');

        if ($response->failed()) {
            throw new \Exception("could not get orders from Kitchen MS: " . $response->body());
        }

        return $response->json();
    }

    public function sendNewOrder()
    {
        $response = Http::post($this->KITCHEN_MS_BASE_URL . '/kitchen/orders');

        if ($response->failed()) {
            throw new \Exception("could not create an order from Kitchen MS: " . $response->body());
        }

        return $response->json();
    }
}
