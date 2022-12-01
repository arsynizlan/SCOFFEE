<?php

namespace Database\Factories;

use Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coffee>
 */
class CoffeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $body = fake()->paragraph(fake()->numberBetween(1, 5));
        $coffes = ['Kopi Communal Berdikari (Java Sumedang)', 'Kopi KWT Mekar Arum (Kopi Tanjoeng)', 'Kopi Barokah Makmur (Kopi Karuhun)', 'Matim Coffee', 'Kopi Maju Mekar (Kopi Boehoen)', 'Kopi Lingga Sari/Sukasari', 'Kopi Gunung Susuru/Kadiran', 'Kopi Hurip Lestari/Gold Dib.'];
        $coffe = fake()->randomElement(($coffes));
        return [
            'name' => fake()->randomElement(($coffes)),
            'origin' => fake()->randomElement(([
                'Gunung Manglayang', 'Gunung Cakrabuana',
                'Gunung Tampomas', 'Rancakalong'
            ])),
            'type' => fake()->randomElement((['Arabica', 'Robusta'])),
            'image' => 'coffee (' . fake()->numberBetween(1, 10) . ')' . '.jpg',
            'description' => '<p>' . $body . '</p>',
            'slug' => Str::slug($coffe),
        ];
    }
}
