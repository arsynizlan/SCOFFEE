<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Comment;
use App\Models\Context;
use App\Models\Category;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

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
