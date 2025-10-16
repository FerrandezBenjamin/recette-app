<?php

namespace App\Http\Controllers;

class DishesFavsController extends Controller
{
    public function addToFavorites($dishId)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }

        if ($user->favoriteDishes()->where('dishes_favs.dish_id', $dishId)->exists()) {
            $user->favoriteDishes()->detach($dishId);
            return response()->json(['message' => 'Plat retiré des favoris'], 201);
        } else {
            $user->favoriteDishes()->attach($dishId);
            return response()->json(['message' => 'Plat ajoute aux favoris'], 200);

        }
    }


    // public function removeFromFavorites($dishId)
    // {
    //     $user = auth()->user();
    //     $user->favoriteDishes()->detach($dishId);

    //     return response()->json(['message' => 'Plat retiré des favoris'], 200);
    // }
}
