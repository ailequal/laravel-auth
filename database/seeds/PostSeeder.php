<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\User;
use App\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // retrieve all users
        $users = User::all();
        // variable for user_id
        $j = 1;

        // cycle every user and create a new post
        foreach ($users as $key => $user) {
            for ($i=0; $i < rand(1, 3); $i++) {
                $post = new Post;
                $post->user_id = $j;
                $post->title = $faker->sentence($nbWords = 3, $variableNbWords = true);
                $post->text = $faker->paragraph($nbSentences = 5, $variableNbSentences = true);
                $post->slug = Str::finish(Str::slug($post->title), '-' . rand(1, 1000));
                $post->save();
            }
            $j++;
        }
    }
}
