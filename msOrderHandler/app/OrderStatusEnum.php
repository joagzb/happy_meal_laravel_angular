<?php

namespace App;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case COOKING = 'cooking';
    case COMPLETED = 'completed';
}
