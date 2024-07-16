<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return collect($this->resource)->map(function ($purchase) {
            return [
                'ingredient' => $purchase['ingredient']['name'],
                'quantityPurchased' => $purchase['amount'],
                'date' => $purchase['updated_at'],
            ];
        })->toArray();
    }
}
