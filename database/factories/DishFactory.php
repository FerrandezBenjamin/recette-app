<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use FakerRestaurant\Provider\fr_FR\Restaurant;
use Xvladqt\Faker\LoremFlickrProvider;

class DishFactory extends Factory
{
    public function definition(): array
    {
        $faker = $this->faker;
        $faker->addProvider(new Restaurant($faker));
        $faker->addProvider(new LoremFlickrProvider($faker));

        return [
            'name' => $faker->foodName(),
            'description' => $faker->text(200),
            'image_path' => $faker->imageUrl(320, 240, 'dish'),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
