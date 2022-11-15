<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            AuthSeeder::class,
            UserSeeder::class,
            EventsSeeder::class,
        ]);
        // $collect = collect(User::all());
        // dd($collect);
    }
}
