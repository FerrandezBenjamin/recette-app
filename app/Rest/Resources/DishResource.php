<?php

namespace App\Rest\Resources;

use Lomkit\Rest\Http\Requests\RestRequest;
use Lomkit\Rest\Http\Resource;
use App\Models\Dish;

class DishResource extends Resource
{
    public static $model = Dish::class;

    public function fields(RestRequest $request): array
    {
        return [
            'dish_id',
            'dishes_name',
            'dishes_description',
            'dishes_image_path',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    public function query(RestRequest $request)
    {
        return Dish::query();
    }

    public function details(RestRequest $request)
    {
        return $this->query($request)->get();
    }


    public function authorizedToIndex(RestRequest $request): bool { return true; }
    public function authorizedToShow(RestRequest $request, $model): bool { return true; }
    public function authorizedToCreate(RestRequest $request): bool { return true; }
    public function authorizedToUpdate(RestRequest $request, $model): bool { return true; }
    public function authorizedToDelete(RestRequest $request, $model): bool { return true; }
}
