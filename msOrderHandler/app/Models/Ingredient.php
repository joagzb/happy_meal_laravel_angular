<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'ingredients';

     /**
      * Get all of the recipes for the Ingredient
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     public function recipes(): HasMany
     {
         return $this->hasMany(Recipe::class);
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
