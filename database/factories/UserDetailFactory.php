<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = 'profile (' . fake()->numberBetween(1, 11) . ').png';
        return [
            'user_id' => User::factory(),
            'description' => fake()->paragraph(fake()->numberBetween(4, 10)),
            'born' => fake()->date(),
            'image' => $user,
            'academic' => fake()->randomElement((['Baru Lulus S1', 'Masih Semester 1', 'Maba Mahasiswa Baheula', 'Baru Semester 12'])),
            'work' => fake()->jobTitle(),
        ];
    }
}
