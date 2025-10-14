<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\ForceLogin;

Auth::routes(['verify' => true, 'reset' => false]);

// Route d’accueil : redirige vers /home une seule fois
Route::get('/', function () {
    return redirect('/home');
});

Route::middleware([ForceLogin::class])->group(function () {
    Route::get('/', fn() => redirect('/home'));
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
