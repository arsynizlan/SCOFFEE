<?php

namespace Database\Seeders;

use App\Models\Coffee;
use App\Models\Education;
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
        Education::factory()->count(100)->create();
        Coffee::factory()->count(8)->create();
    }
}
