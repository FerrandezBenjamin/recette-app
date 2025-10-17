<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Xvladqt\Faker\LoremFlickrProvider;
use FakerRestaurant\Provider\fr_FR\Restaurant;

class DishFactory extends Factory
{
    public function definition(): array
    {
        $faker = $this->faker;
        $faker->addProvider(new Restaurant($faker));
        $faker->addProvider(new LoremFlickrProvider($faker));

        // Génération du nom et de la description
        $name = $faker->foodName();
        $description = $faker->sentence();
        $imagePath = null;

        try {

            $tmpFile = $faker->imageUrl(320, 240, ['dish']);

            if (empty($tmpFile) || str_contains($tmpFile, "\0")) {
                $tmpFile = "https://picsum.photos/320/240?random=" . rand(1, 9999);
            }

            $headers = @get_headers($tmpFile);
            if (!$headers || strpos($headers[0], '200') === false) {
                $tmpFile = "https://picsum.photos/320/240?random=" . rand(1, 9999);
            }

            $contents = @file_get_contents($tmpFile);

            if ($contents !== false) {
                $filename = 'dish_' . uniqid() . '.jpg';

                if (!file_exists(public_path('images'))) {
                    mkdir(public_path('images'), 0777, true);
                }

                $newFilePath = public_path('images/' . $filename);
                file_put_contents($newFilePath, $contents);

                $imagePath = $filename;
            }

        } catch (\Exception $e) {
            $imagePath = null;
        }

        return [
            'dishes_name' => $name,
            'dishes_description' => $description,
            'dishes_image_path' => $imagePath,
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
