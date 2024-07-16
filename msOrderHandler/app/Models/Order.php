<?php

namespace App\Models;

use App\OrderStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'orders';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'status' => OrderStatusEnum::class,
    ];

    /**
     * Get the dish that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}
