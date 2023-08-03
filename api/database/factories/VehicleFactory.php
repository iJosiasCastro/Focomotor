<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Fuel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(5000, 99999000),
            'year' => $this->faker->numberBetween(1950, 2022),
            'mileage' => $this->faker->numberBetween(0, 999000),
            'description' => $this->faker->text(2000),

            'fuel_id' => Fuel::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
