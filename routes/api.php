<?php

use Lomkit\Rest\Facades\Rest;
use App\Rest\Resources\UserResource;
use App\Rest\Resources\DishResource;

Rest::resource('users', UserResource::class);
Rest::resource('dishes', DishResource::class);