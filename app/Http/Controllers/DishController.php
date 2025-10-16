<?php

namespace App\Http\Controllers;

use Faker\Factory as FakerFactory;
use Xvladqt\Faker\LoremFlickrProvider;
use FakerRestaurant\Provider\fr_FR\Restaurant as FakerRestaurantProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dish;
use App\Notifications\DishCreatedNotification;

class DishController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allDishes()
    {
        $allDishes = Dish::paginate(10);

        return view('dishes.all_dishes', compact([
            'allDishes'
        ]));
    }

    public function displayCreateDish()
    {
        $this->authorize('creation plat');
        return view('dishes.create_dish');
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

        $name = $request->input('name') ?: $faker->foodName();
        $description = $request->input('description') ?: $faker->sentence();

        $path = null;

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

        return redirect()->route('display_all_dishes')->with('success', 'Recette créée avec succès !');
    }

    public function deleteDish(Request $req)
    {
        $this->authorize('suppression plat');

        $value = $req->validate([
            'id_dish' => 'required|exists:App\Models\Dish,dish_id'
        ]);

        if($dishWas = Dish::find($value['id_dish'])) {
            $dishWas->deleteCascade();
            return redirect()->route('display_all_dishes')->with('success', 'Recette supprimée.');

        } else {
            return redirect()->route('display_all_dishes')->withErrors('message', "La recette n'a pas été trouvée" );
        }
    }

    public function displayEditDish($id)
    {
        $this->authorize('creation plat');

        if($dishWas = Dish::find($id)) {


            // dd($dishWas->getDescriptionDish());


            return view('dishes.dish', compact([
                'dishWas'
            ]));
        } else {
            return redirect()->route('display_all_dishes')->withErrors('message', "La recette n'a pas été trouvée" );
        }
    }



    public function editDish(Request $req)
    {
        dd($req->all());
        dd('coucou');
    }


    public function update(Request $request, Dish $dish)
    {
        $dish->update($request->all());
        return redirect()->route('home');
    }
}
