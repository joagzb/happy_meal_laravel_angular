<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IngredientPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $ingredientName;
    public $quantity;

    public function __construct($ingredientName, $quantity)
    {
        $this->ingredientName = $ingredientName;
        $this->quantity = $quantity;
    }
}
