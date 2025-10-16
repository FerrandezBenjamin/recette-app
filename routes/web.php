<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\DishesFavsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\ForceLogin;

Auth::routes(['verify' => true, 'reset' => false]);

Route::get('/', function () {
    return redirect('/home');
});

Route::middleware([ForceLogin::class])->group(function () {
    Route::get('/', fn() => redirect('/home'));
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/recette', [DishController::class, 'allDishes'])->name('display_all_dishes');
    Route::get('/recette/nouvelle', [DishController::class, 'displayCreateDish'])->name('display_new_dish');
    Route::post('/recette/nouvelle', [DishController::class, 'recDish'])->name('rec_dish');
    Route::post('/recette/supprimer', [DishController::class, 'deleteDish'])->name('delete_dish');
    Route::post('/dishes/{id}/favorite', [DishesFavsController::class, 'addToFavorites'])->name('dishes.favorite');

});
