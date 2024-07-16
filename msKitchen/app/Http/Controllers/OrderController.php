<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderQueryRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{

    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrderQueryRequest $request)
    {
        $orders = $this->orderService->filterByStatus($request);
        return new OrderResource($orders);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new OrderResource(Order::findOrFail($id)->with(['dish']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $this->orderService->receiveOrder();

        return response()->json(['message' => 'Order received'], 200);
    }

}
