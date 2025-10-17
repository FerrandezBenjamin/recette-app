<?php

use Lomkit\Rest\Facades\Rest;
use App\Rest\Resources\UserResource;

Rest::resource('users', UserResource::class);