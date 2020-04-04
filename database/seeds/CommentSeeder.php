<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
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
         // retrieve all posts
         $posts = Post::all();
         // variable for post_id
         $j = 1;

         // cycle every post and create a new comment
        foreach ($posts as $key => $post) {
            for ($i=0; $i < rand(1, 3); $i++) {
            $comment = new Comment;
            $comment->post_id = $j;
            $comment->name = $faker->firstName() . ' ' . $faker->lastName();
            $comment->email = $faker->email();
            $comment->text = $faker->paragraph($nbSentences = 1, $variableNbSentences = true);
            $comment->save();
            }
            $j++;
        }
    }
}
