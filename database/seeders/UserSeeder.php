<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        UserDetail::create([
            'id' => $admin->id,
            'description' => "Pelajar Dari Bandung",
            'born' => "2002-12-04",
            'academic' => "STM Pembangunan Bandung",
            'work' => "META .Inc",
        ]);
        $admin->assignRole('SuperAdmin');
    }
}
