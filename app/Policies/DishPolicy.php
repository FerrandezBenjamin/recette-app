<?php

namespace App\Policies;

use App\Models\Dish;

class DishPolicy
{
    public function viewAny(?Dish $dish): bool
    {
        return true;
    }

    public function view(?Dish $dish, Dish $model): bool
    {
        return true;
    }

    public function create(?Dish $dish): bool
    {
        return true;
    }

    public function update(?Dish $dish, Dish $model): bool
    {
        return true;
    }

    public function delete(?Dish $dish, Dish $model): bool
    {
        return true;
    }
}
