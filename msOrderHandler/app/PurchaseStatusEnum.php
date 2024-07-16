<?php

namespace App;

enum PurchaseStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
}
