<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Context;
use App\Models\Category;
use App\Models\Forum;
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

        Category::factory(5)->create();
        Context::factory(5)->create();


        $this->call([
            AuthSeeder::class,
            UserSeeder::class,
            EventsSeeder::class,
        ]);
    }
}
