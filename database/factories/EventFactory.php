<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserDetail;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $model = User::with('roles')->first();
        $model = DB::table('users')
            ->join('roles', 'users.id', '=', 'roles.id')
            ->where('roles.name', '=', 'Admin')
            ->get()->random()->id;
        $title = fake()->sentence(fake()->numberBetween(4, 5));
        return [
            'user_id' => $model,
            'image' => fake()->imageUrl(120, 50, 'cats'),
            'title' => $title,
            'slug' => Str::slug($title),
            'date' => fake()->date,
            'body' => fake()->paragraph(fake()->numberBetween(5, 20)),
            'status_publish' =>  fake()->numberBetween(0, 1),
        ];
    }
}
