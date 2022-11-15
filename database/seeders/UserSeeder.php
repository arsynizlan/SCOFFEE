<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Faker\Factory;
use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'Arsy Nizlan Ramadhan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('SuperAdmin');

        User::create([
            'name' => $faker->name(),
            'email' => 'praktisi@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('Admin')->user_detail()->create([
            'image' => $faker->imageUrl(50, 50, 'profile'),
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
            'image' => $faker->imageUrl(50, 50, 'profile'),
            'description' => $faker->paragraph($faker->numberBetween(2, 5)),
            'born' => $faker->date(),
            'academic' => $faker->randomElement((['Baru Lulus S1', 'Masih Semester 1', 'Maba Mahasiswa Baheula', 'Baru Semester 12'])),
            'work' => $faker->jobTitle()
        ]);
    }
}
