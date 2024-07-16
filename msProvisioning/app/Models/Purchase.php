<?php

namespace App\Models;

use App\PurchaseStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'purchases';

    private $BUY_ATTEMPTS_LIMIT = 3;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'status' => PurchaseStatusEnum::class,
    ];

    protected $fillable = [
        'ingredient_id',
        'amount',
        'amountPending',
        'status',
        'buyAttempts',
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

    public function updateStatusByQuantityReceived(int $quantityReceived): void
    {
        $amountPending = $quantityReceived >= $this->amountPending ? 0 : $this->amountPending - $quantityReceived;
        $nextStatus = $this->amountPending == 0 ? PurchaseStatusEnum::COMPLETED : PurchaseStatusEnum::PENDING;

        $this->update([
            'status' => $nextStatus,
            'amountPending' => $amountPending,
        ]);
    }

    public function updateStatusByBuyAttempts(): void
    {
        $nextStatus = $this->hasReachedRetryBuyLimit() ? PurchaseStatusEnum::REJECTED : PurchaseStatusEnum::PENDING;

        $this->update([
            'buyAttempts' => $this->buyAttempts,
            'status' => $nextStatus,
        ]);
    }

    public function isPurchaseCompleted(): bool
    {
        return $this->status == PurchaseStatusEnum::COMPLETED;
    }

    public function isPurchasePending(): bool
    {
        return $this->status == PurchaseStatusEnum::PENDING;
    }

    private function hasReachedRetryBuyLimit(): bool
    {
        return $this->buyAttempts >= $this->BUY_ATTEMPTS_LIMIT;
    }
}
