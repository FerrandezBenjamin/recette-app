<?php

namespace App\Rest\Resources;

use Lomkit\Rest\Http\Resource;
use Lomkit\Rest\Http\Requests\RestRequest;

class UserResource extends Resource
{
    public static $model = \App\Models\User::class;

    public function authorizedToIndex(RestRequest $request): bool
    {
        return true;
    }

    public function authorizedToShow(RestRequest $request, $model): bool
    {
        return true;
    }

    public function authorizedToCreate(RestRequest $request): bool
    {
        return true;
    }

    public function authorizedToUpdate(RestRequest $request, $model): bool
    {
        return true;
    }

    public function authorizedToDelete(RestRequest $request, $model): bool
    {
        return true;
    }

    public function fields(RestRequest $request): array
    {
        return [
            'id',
            'name',
            'email',
        ];
    }
}
