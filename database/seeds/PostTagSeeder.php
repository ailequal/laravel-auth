<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\DatabaseManager;
use Carbon\Carbon;
use App\Post;
use App\Tag;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // retrieve data
        $posts = Post::all();
        $tagsCount = count(Tag::all());

        // cycle every post
        foreach ($posts as $post) {
            // add a new tag
            for ($i=0; $i < rand(0, 1); $i++) {
                $tagNew = rand(1, $tagsCount);
                // add tag
                $post->tags()->attach($tagNew);
            }
        }
    }
}
