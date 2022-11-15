<?php

namespace Database\Seeders;

use App\Models\Event as ModelsEvent;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsEvent::factory()->count(100)->create();

        // $faker = Factory::create();

        // for ($i = 0; $i < 10; $i++) {
        //     $title = $faker->sentence();
        //     ModelsEvent::create([
        //         'image' => $faker->imageUrl(120, 50, 'cats'),
        //         'title' => $title,
        //         'slug' => Str::slug($title),
        //         'body' => $faker->paragraph(2),
        //         'date' => $faker->date,
        //         'status_publish' =>  $faker->numberBetween(0, 1),
        //         'user_id' => User::all()->random()->id,
        //     ]);
        // }
    }
}
