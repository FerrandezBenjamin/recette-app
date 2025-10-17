<?php

namespace App\Rest\Controllers;

use Lomkit\Rest\Http\Controllers\Controller;
use App\Rest\Resources\UserResource;

class UsersController extends Controller
{
    public static $resource = UserResource::class;
}
