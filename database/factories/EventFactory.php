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
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('role_id', '=', 2)
            ->get()->random()->id;
        $title = fake()->unique()->sentence(fake()->numberBetween(4, 5));
        $body = fake()->paragraph(fake()->numberBetween(5, 20));

        return [
            'user_id' => $model,
            'image' => '(' . fake()->numberBetween(1, 13) . ')' . '.png',
            'title' => $title,
            'slug' => Str::slug($title),
            'date' => fake()->date,
            'body' => '<p>' . $body . '</p>',
            'status_publish' =>  fake()->numberBetween(0, 1),
        ];
    }
}
