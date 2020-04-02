<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
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
        for ($i=0; $i < 6; $i++) { 
            $post = new Post;
            if ($i < 3) {
                $post->user_id = 1;
            } else {
                $post->user_id = 2;
            }
            $post->title = $faker->sentence($nbWords = 3, $variableNbWords = true);
            $post->text = $faker->paragraph($nbSentences = 5, $variableNbSentences = true);
            $post->path_image = 'https://i.pravatar.cc/150?img=' . rand(1, 30);
            $post->slug = Str::finish(Str::slug($post->title), '-' . rand(1, 1000));

            $post->save();
        }
    }
}
