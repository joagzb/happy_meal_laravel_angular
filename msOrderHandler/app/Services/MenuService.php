<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MenuService
{
    private $KITCHEN_MS_BASE_URL;

    public function __construct()
    {
        $this->KITCHEN_MS_BASE_URL = (string) env('KITCHEN_MS_BASE_URL');
    }

    public function getDishes()
    {
        $response = Http::get($this->KITCHEN_MS_BASE_URL . '/kitchen/menu');

        if ($response->failed()) {
            throw new \Exception("could not get dishes from Kitchen MS: " . $response->body());
        }

        return $response->json();
    }
}
