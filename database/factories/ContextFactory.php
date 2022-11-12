<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContextFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement((['Diskusi', 'Berita', 'Usaha', 'Info', 'Daging'])),
            'image' => fake()->imageUrl('50', '50', 'Contex')
        ];
    }
}
