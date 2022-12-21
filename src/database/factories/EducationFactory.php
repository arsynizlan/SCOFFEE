<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $model = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('role_id', '=', 2)
            ->get()->random()->id;
        $title = fake()->unique()->sentence(fake()->numberBetween(4, 5));
        $body = fake()->paragraph(fake()->numberBetween(5, 20));
        $category = ['Kopi Asik', 'Sumedang Kopi', 'Pejuang Coffee', 'Benih Coffee'];
        return [
            'user_id' => $model,
            'image' => 'education (' . fake()->numberBetween(1, 11) . ').png',
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => '<p>' . $body . '</p>',
            'category' => fake()->randomElement($category),
        ];
    }
}
