<?php

namespace App\Services;

use App\Events\OrderFinished;
use App\Events\OrderReceived;
use App\Http\Requests\OrderQueryRequest;
use App\Models\Order;
use App\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function filterByStatus(OrderQueryRequest $request)
    {
        $query = Order::with(['dish']);
        if ($request->status) {
            Log::debug("filtering orders by status: " . $request->status);
            $query->where('status', $request->status);
        }
        return $query->get();
    }

    public function getPendingOrdersWaitingForIngredients(array $ingredientsNames)
    {
        return Order::where('status', OrderStatusEnum::PENDING)->whereHas('dish.recipes.ingredient', function (Builder $query) use ($ingredientsNames) {
            $query->whereIn('name', $ingredientsNames);
        })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function prepareOrder(Order $order): void
    {
        // send event to start cooking
        event(new OrderReceived($order));
    }

    public function receiveOrder(): void
    {
        //create order
        $order = new Order();
        $order->status = OrderStatusEnum::PENDING;
        $order->assignDishRandomly();

        // prepare order
        $this->prepareOrder($order);
    }
}
