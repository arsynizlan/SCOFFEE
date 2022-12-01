<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Context;
use Faker\Factory;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use App\Models\Forum;
use Hamcrest\Core\Every;
use Illuminate\Support\Facades\Hash;

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
            'image' => 'profile (' . $faker->numberBetween(1, 11) . ').png',
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
            'image' => 'profile (' . $faker->numberBetween(1, 11) . ').png',
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
            'image' => 'profile (' . $faker->numberBetween(1, 11) . ').png',
            'description' => $faker->paragraph($faker->numberBetween(2, 5)),
            'born' => $faker->date(),
            'academic' => $faker->randomElement((['Baru Lulus S1', 'Masih Semester 1', 'Maba Mahasiswa Baheula', 'Baru Semester 12'])),
            'work' => $faker->jobTitle()
        ]);
    }
}
