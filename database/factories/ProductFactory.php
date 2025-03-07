<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition(): array
    {
        return [
            'title' => fake()->word(),  // Generates a single word
            'description' => fake()->sentence(), // Generates a sentence
            'price' => fake()->randomFloat(2, 10, 1000), // Generates a decimal price
            'qtyInstock' => fake()->numberBetween(1, 100), // Random stock quantity
            'categoryId' => Category::inRandomOrder()->first()?->id ?? Category::factory()->create()->id,
        ];
    }
}
