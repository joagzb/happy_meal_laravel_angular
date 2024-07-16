<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientsAvailableWebhookRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProvisioningWebhookController extends Controller
{

    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function __invoke(IngredientsAvailableWebhookRequest $request)
    {
        Log::debug("webhook incoming from provisionerMS: " . json_encode($request->all()));
        $ingredientNameList = collect($request->validated('ingredients'))->pluck('name')->toArray();
        $pendingOrders = $this->orderService->getPendingOrdersWaitingForIngredients($ingredientNameList);
        if($pendingOrders && $pendingOrders->count() > 0) {
            $this->orderService->prepareOrder($pendingOrders->first());
        }
    }
}
