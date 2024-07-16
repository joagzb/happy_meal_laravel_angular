<?php

namespace App\Listeners;

use App\Events\OrderFinished;
use App\Events\OrderReadyToCook;
use App\Events\OrderReceived;

interface OrderStatusHandler
{
    public function handleOrderReceived(OrderReceived $event): void;
    public function handleOrderFinished(OrderFinished $event): void;
    public function handleOrderReadyToCook(OrderReadyToCook $event): void;
}
