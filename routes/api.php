<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lomkit\Rest\Facades\Rest;
use App\Rest\Controllers\UsersController;

Rest::resource('users', UsersController::class);
