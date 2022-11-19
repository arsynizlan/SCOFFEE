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
        $user = 'posting (' . fake()->numberBetween(1, 11) . ').png';
        $image = fake()->randomElement([$user, $user, $user, null]);

        return [
            'title' => fake()->sentence(fake()->numberBetween(4, 7)),
            'description' => fake()->paragraph(fake()->numberBetween(6, 9)),
            'image' => $image
        ];
    }
}
