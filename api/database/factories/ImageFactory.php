<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $element = $this->faker->randomElement([
            'bc0d08575cac4d9b47b5ce84cb28f8d94IItCU77RK',
            '76a527e141a8b40586a90f283414fa99bWpA1gujn8',
            '9c878fa830d7ce14a6ac4e3ad97efb1cOqqL7abtaS',
            '7f1304ddc33b7a2880113b64840b6e45cTMu7Ui6wS',
            'bd93806cd30adb371b7211265d7e15e3crjlmBaCv9',
            'dth8hj6cd30adb371b7211265d0b6e45cTMu7Ui6wS',
            'ae8h8t2dc33b7a2880113b64840b6e45cTMu7Ui6wS',
            'as4a5ge141a8b40586a90f283414fa99bWpA1gujn8',
        ]) . '.jpeg';
        return [
            'name' => $element
            // 'name' => 'storage/vehicles' . $this->faker->image('public/storage/vehicles', 640, 480, null, false)
        ];
    }
}
