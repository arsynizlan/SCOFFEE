<?php

namespace Database\Seeders;

use App\Models\User;
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
        $admin = User::create([
            'name' => 'Arsy Nizlan Ramadhan',
            'email' => 'arsynizlan@gmail.com',
            'password' => Hash::make('arsynizlan'),
        ]);
        $admin->assignRole('Admin');
    }
}