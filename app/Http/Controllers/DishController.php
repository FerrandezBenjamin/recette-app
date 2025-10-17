<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use App\Mail\DishCreatedMail;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Xvladqt\Faker\LoremFlickrProvider;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DishCreatedNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Auth\Access\AuthorizationException;
use FakerRestaurant\Provider\fr_FR\Restaurant as FakerRestaurantProvider;

class DishController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function allDishes()
    {
        $user       = auth()->user();
        $all        = Dish::with('favoredBy')->orderBy('dish_id')->get();
        $sorted     = $all->sortByDesc(fn($dish) => $user->favoriteDishes->contains($dish->getDishId()))->values();
        $perPage    = 10;
        $page       = request()->get('page', 1);
        $items      = $sorted->forPage($page, $perPage);

        $paginated = new LengthAwarePaginator(
            $items,
            $sorted->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dishes.all_dishes', [
            'allDishes' => $paginated,
        ]);
    }


    public function displayCreateDish()
    {
        try {
            // $this->authorize('creation plat');
            return view('dishes.create_dish');
        } catch (AuthorizationException $e) {
            return redirect()
                ->route('display_all_dishes')
                ->withErrors("Vous n'avez pas les droits");
        }
    }

    public function recDish(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2048',
            'image' => 'nullable|image|max:2048',
        ]);

        $faker = FakerFactory::create('fr_FR');
        $faker->addProvider(new FakerRestaurantProvider($faker));
        $faker->addProvider(new LoremFlickrProvider($faker));

        $name        = $request->input('name') ?: $faker->foodName();
        $description = $request->input('description') ?: $faker->sentence();
        $path        = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        } else {
            try {
                $tmpFile = $faker->imageUrl(320, 240, ['dish']);

                if (empty($tmpFile) || str_contains($tmpFile, "\0")) {
                    $tmpFile = "https://picsum.photos/320/240?random=" . rand(1, 9999);
                }

                $headers = get_headers($tmpFile);
                if (!$headers || strpos($headers[0], '200') === false) {
                    $tmpFile = "https://picsum.photos/320/240?random=" . rand(1, 9999);
                }

                $contents = file_get_contents($tmpFile);

                if ($contents !== false) {
                    $filename = 'dish_' . uniqid() . '.jpg';
                    $tempPath = storage_path('app/tmp_' . $filename);

                    file_put_contents($tempPath, $contents);

                    if (!file_exists(public_path('images'))) {
                        mkdir(public_path('images'), 0777, true);
                    }

                    $newFilePath = public_path('images/' . $filename);
                    rename($tempPath, $newFilePath);

                    $path =  $filename;
                } else {
                    $path = null;
                }

            } catch (\Exception $e) {
                // \Log::error('Erreur lors de la génération d\'image : ' . $e->getMessage());
                $path = null;
            }
        }

        $dish = \App\Models\Dish::create([
            'dishes_name' => $name,
            'dishes_description' => $description,
            'dishes_image_path' => $path,
            'user_id' => Auth::id(),
        ]);

        Mail::to(Auth::user()->email)->send(new DishCreatedMail($dish));

        return redirect()->route('display_all_dishes')->with('message', 'Recette créée avec succès !');
    }

    public function deleteDish(Request $req)
    {
        $this->authorize('suppression plat');

        $value = $req->validate([
            'id_dish' => 'required|exists:App\Models\Dish,dish_id'
        ]);

        if($dishWas = Dish::find($value['id_dish'])) {
            $dishWas->deleteCascade();
            return redirect()->route('display_all_dishes')->with('message', 'Recette supprimée.');

        } else {
            return redirect()->route('display_all_dishes')->withErrors('message', "La recette n'a pas été trouvée" );
        }
    }

    public function displayEditDish($id)
    {
        if($dishWas = Dish::find($id)) {
            return view('dishes.dish', compact([
                'dishWas'
            ]));
        } else {
            return redirect()->route('display_all_dishes')->withErrors('message', "La recette n'a pas été trouvée" );
        }
    }



    public function editDish(Request $req)
    {

        $values = $req->validate([
            'id_dish' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        if($dishWas = Dish::find($values['id_dish']))
        {   
            $dishWas->dishes_name           = $values['name'];
            $dishWas->dishes_description    = $values['description'];
            $dishWas->update();

            return redirect()->route('display_all_dishes')->with('message', 'La recette a bien été modifié');
        } else {
            return redirect()->route('display_all_dishes')->withErrors("La recette n'a pas été trouvée");
        }
    }


    public function update(Request $request, Dish $dish)
    {
        $dish->update($request->all());
        return redirect()->route('home');
    }


    public function generateDishes(Request $request)
    {
        $count = (int) $request->query('count', 10);

        $count = max(1, min($count, 100));

        \App\Models\Dish::factory()->count($count)->create();

        return redirect()
            ->route('display_all_dishes')
            ->with('message', "{$count} recettes générées avec succès.");
    }

}
