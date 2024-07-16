<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KitchenWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        Log::debug("Order Ready webhook status incoming from kitchenMS: " . json_encode($request->all()));

        $frontendWebhookUrl = env('FRONTEND_BASE_URL') . "/webhook";
        Log::debug("resending webhook to frontend: " . $frontendWebhookUrl);
        Http::post($frontendWebhookUrl, $request->get('order'));
    }
}
