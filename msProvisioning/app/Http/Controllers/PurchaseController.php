<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\PurchaseStatusEnum;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $purchases = Purchase::all()->where('status', PurchaseStatusEnum::COMPLETED)->load(['ingredient']);
        return new PurchaseResource($purchases);
    }
}
