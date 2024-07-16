<?php

namespace App\Models;

use App\PurchaseStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'purchases';

    private $BUY_ATTEMPTS_LIMIT = 3;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'status' => PurchaseStatusEnum::class,
    ];

    /**
     * Get the ingredient that owns the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }

}
