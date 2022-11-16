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
            'name' => fake()->unique()->randomElement((['Sumedang Coffe', 'Coffe Local', 'Rosting', 'Barista', 'Manglayang Coffe'])),
            'image' => fake()->imageUrl('50', '50', 'Kategori')
        ];
    }
}
