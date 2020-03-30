<?php

use Illuminate\Database\Seeder;
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
            $post->save();
        }
    }
}
