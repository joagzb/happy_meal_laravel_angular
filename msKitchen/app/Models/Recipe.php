<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'recipes';

    protected $casts = [
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s',
     ];

     /**
      * Get the dish that owns the Recipe
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function dish(): BelongsTo
     {
         return $this->belongsTo(Dish::class);
     }

     public function ingredient(): BelongsTo
     {
         return $this->belongsTo(Ingredient::class);
     }
}
