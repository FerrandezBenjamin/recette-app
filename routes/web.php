<?php

use App\Http\Middleware\ForceLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DishesFavsController;

Auth::routes(['verify' => true, 'reset' => false]);

Route::get('/', function () {
    return redirect('/home');
});

Route::middleware([ForceLogin::class])->group(function () {
    Route::get('/', fn() => redirect('/home'));
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //toute les recettes
    Route::get('/recettes', [DishController::class, 'allDishes'])->name('display_all_dishes');

    //creation nouvelle recette
    Route::get('/recette/nouvelle', [DishController::class, 'displayCreateDish'])->name('display_new_dish');
    Route::post('/recette/nouvelle', [DishController::class, 'recDish'])->name('rec_dish');

    //delete
    Route::post('/recette/supprimer', [DishController::class, 'deleteDish'])->name('delete_dish');

    //gestion fav
    Route::post('/plat/{id}/favorite', [DishesFavsController::class, 'addToFavorites'])->name('dishes.favorite');

    //modification
    Route::get('/recette/{id}', [DishController::class, 'displayEditDish'])->name('dish');
    Route::post('/recette/update', [DishController::class, 'editDish'])->name('edit_dish');

});
