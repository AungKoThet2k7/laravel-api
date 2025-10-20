<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "price" => $this->faker->numberBetween(500, 10000),
            "stock" => $this->faker->numberBetween(5, 30),
            "user_id" => User::inRandomOrder()->first()->id,
        ];
    }
}
