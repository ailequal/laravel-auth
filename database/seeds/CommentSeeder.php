<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 8; $i++) { 
            $comment = new Comment;
            if ($i < 2) {
                $comment->post_id = 1;
            } elseif ($i < 4) {
                $comment->post_id = 2;
            } elseif ($i < 6) {
                $comment->post_id = 3;
            } else {
                $comment->post_id = 4;
            }
            $comment->name = $faker->firstName() . ' ' . $faker->lastName();
            $comment->email = $faker->email();
            $comment->text = $faker->paragraph($nbSentences = 1, $variableNbSentences = true);
            $comment->save();
        }
    }
}
