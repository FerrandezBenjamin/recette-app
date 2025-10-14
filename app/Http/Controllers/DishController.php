<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DishCreatedNotification;

class DishController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dishes = Dish::paginate(10);
        return view('home', compact('dishes'));
    }

    public function create()
    {
        $this->authorize('creation plat');
        return view('dishes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dishes', 'public');
        }

        $dish = Dish::create([
            'dishes_name' => $request->name,
            'dishes_description' => $request->description,
            'dishes_image_path' => $path,
            'user_id' => Auth::id(),
        ]);

        Auth::user()->notify(new DishCreatedNotification($dish));

        return redirect()->route('home')->with('success', 'Recette créée avec succès !');
    }

    public function show(Dish $dish)
    {
        return view('dishes.show', compact('dish'));
    }

    public function edit(Dish $dish)
    {
        return view('dishes.edit', compact('dish'));
    }

    public function update(Request $request, Dish $dish)
    {
        $dish->update($request->all());
        return redirect()->route('home');
    }

    public function destroy(Dish $dish)
    {
        $this->authorize('suppression plat');
        $dish->delete();
        return redirect()->route('home')->with('success', 'Recette supprimée.');
    }
}
