<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image' => fake()->imageUrl(120, 50, 'cats'),
            'title' => fake()->sentence(fake()->numberBetween(4, 9)),
            'slug' => fake()->slug(),
            'body' => fake()->paragraphs(fake()->numberBetween(5, 20)),
        ];
    }
}
