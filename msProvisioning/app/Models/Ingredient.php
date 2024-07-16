<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'ingredients';

    protected $fillable = [
        'quantity',
    ];


    public function isAvailable(int $quantityAsked): bool
    {
        return $this->quantity >= $quantityAsked;
    }

    public function decrementStock(int $quantityRequested): void
    {
        $this->update(['quantity' => $this->quantity - $quantityRequested]);
    }

    public function incrementStock(int $quantity): void
    {
        $this->update(['quantity' => $this->quantity + $quantity]);
    }

    /**
      * Get all of the purchases for the Ingredient
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
      public function purchases(): HasMany
      {
          return $this->hasMany(Purchase::class);
      }

}
