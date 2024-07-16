<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use App\Services\StockService;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{

    private $stockService;

    public function __construct()
    {
        $this->stockService = new StockService();
    }

    public function getIngredients()
    {
        try {
            $response = $this->stockService->getIngredients();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($response, 200);
    }

    public function getPurchases(): PurchaseResource
    {
        try {
            $response = $this->stockService->getPurchases();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return new PurchaseResource($response['data']);
    }
}
