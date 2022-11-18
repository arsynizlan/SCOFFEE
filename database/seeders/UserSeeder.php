<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Context;
use Event;
use Faker\Factory;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use App\Models\Event as ModelEvent;
use App\Models\Forum;
use Hamcrest\Core\Every;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $user = 'profile (' . $faker->numberBetween(1, 11) . ').png';
        User::create([
            'name' => 'Arsy Nizlan Ramadhan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('SuperAdmin')->user_detail()->create([
            'image' => $user,
            'description' => $faker->paragraph($faker->numberBetween(2, 5)),
            'born' => $faker->date(),
            'academic' => $faker->randomElement((['Baru Lulus S1', 'Masih Semester 1', 'Maba Mahasiswa Baheula', 'Baru Semester 12'])),
            'work' => $faker->jobTitle()
        ]);

        User::create([
            'name' => $faker->name(),
            'email' => 'praktisi@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('Admin')->user_detail()->create([
            'image' => $user,
            'description' => $faker->paragraph($faker->numberBetween(2, 5)),
            'born' => $faker->date(),
            'academic' => $faker->randomElement((['Baru Lulus S1', 'Masih Semester 1', 'Maba Mahasiswa Baheula', 'Baru Semester 12'])),
            'work' => $faker->jobTitle()
        ]);

        User::create([
            'name' => $faker->name(),
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('User')->user_detail()->create([
            'image' => $user,
            'description' => $faker->paragraph($faker->numberBetween(2, 5)),
            'born' => $faker->date(),
            'academic' => $faker->randomElement((['Baru Lulus S1', 'Masih Semester 1', 'Maba Mahasiswa Baheula', 'Baru Semester 12'])),
            'work' => $faker->jobTitle()
        ]);

        UserDetail::factory(50)
            ->create()
            ->each(
                function ($user) {
                    Forum::factory()->create(
                        [
                            'user_id' => $user->id,
                            'category_id' => Category::all()->random()->id,
                            'context_id' => Context::all()->random()->id,
                        ],
                    )->each(
                        function ($forum) {
                            Comment::factory()->create([
                                'forum_id' => $forum->id
                            ]);
                        }
                    );
                }
            );
    }
}
