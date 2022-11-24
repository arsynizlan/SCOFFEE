<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement((['Sumedang Coffee', 'Coffee Local', 'Roasting', 'Barista', 'Manglayang Coffee'])),
            'image' => 'category (' . fake()->unique()->numberBetween(1, 5) . ').png'
        ];
    }
}
