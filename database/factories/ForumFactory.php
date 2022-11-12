<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ForumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(fake()->numberBetween(4, 7)),
            'description' => fake()->paragraphs(fake()->numberBetween(6, 9)),
            'image' => fake()->imageUrl(70, 90, 'Gambar Posting')
        ];
    }
}
