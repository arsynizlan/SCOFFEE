<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Context;
use App\Models\User;
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
        // $context = Context::all()->random()->id;
        // $category = Category::all()->random()->id;
        return [
            'title' => fake()->sentence(fake()->numberBetween(4, 7)),
            'description' => fake()->paragraph(fake()->numberBetween(6, 9)),
            'image' => fake()->imageUrl(70, 90, 'Gambar Posting')
        ];
    }
}
