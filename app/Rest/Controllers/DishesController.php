<?php

namespace App\Rest\Controllers;

use Lomkit\Rest\Http\Controllers\Controller;
use App\Rest\Resources\DishResource;

class UsersController extends Controller
{
    public static $resource = DishResource::class;
}
