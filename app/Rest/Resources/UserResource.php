<?php

namespace App\Rest\Resources;

use Lomkit\Rest\Http\Requests\RestRequest;
use Lomkit\Rest\Http\Resource;
use App\Models\User;

class UserResource extends Resource
{
    public static $model = User::class;

    public function fields(RestRequest $request): array
    {
        return [
            'id',
            'name',
            'email',
        ];
    }

    public function query(RestRequest $request)
    {
        return User::query();
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
