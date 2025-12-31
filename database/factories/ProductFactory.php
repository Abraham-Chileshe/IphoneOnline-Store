<?php

namespace Database\Factories;

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
            'name' => fake()->words(3, true) . ' iPhone',
            'brand' => 'Apple',
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 499, 1599),
            'old_price' => fake()->optional()->randomFloat(2, 600, 1799),
            'image' => '/images/products/default.png',
            'stock' => fake()->numberBetween(0, 100),
            'category' => fake()->randomElement(['iPhone 15', 'iPhone 14', 'iPhone 13', 'Accessories']),
            'rating' => fake()->randomFloat(1, 3.5, 5.0),
            'reviews_count' => fake()->numberBetween(0, 500),
            'is_active' => true,
        ];
    }
}
