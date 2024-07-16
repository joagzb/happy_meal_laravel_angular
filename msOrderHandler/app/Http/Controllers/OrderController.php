<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private $orderService;
    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function getOrders(Request $request)
    {
        try {
            $orders = $this->orderService->getOrders();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($orders, 200);
    }

    public function setOrder(Request $request)
    {
        try {
            $response = $this->orderService->sendNewOrder();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($response, 200);
    }
}
