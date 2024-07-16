<?php

namespace App\Http\DTOs;

class IngredientDTO
{
    public readonly string $name;
    public readonly int $quantity;
    public readonly bool $availability;

    public function __construct(string $name, int $quantity, bool $availability)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->availability = $availability;
    }
}
