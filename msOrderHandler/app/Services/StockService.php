<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StockService
{
    private $PROVISIONING_MS_BASE_URL;

    public function __construct()
    {
        $this->PROVISIONING_MS_BASE_URL = (string) env('PROVISIONING_MS_BASE_URL');
    }

    public function getIngredients()
    {
        $response = Http::get($this->PROVISIONING_MS_BASE_URL . '/stock');

        if ($response->failed()) {
            throw new \Exception("could not get ingredients from Provisioning MS: " . $response->status());
        }

        return $response->json();
    }

    public function getPurchases()
    {
        $response = Http::get($this->PROVISIONING_MS_BASE_URL . '/stock/purchases');

        if ($response->failed()) {
            throw new \Exception("could not get purchases from Provisioning MS: " . $response->body());
        }

        return $response->json();
    }
}
