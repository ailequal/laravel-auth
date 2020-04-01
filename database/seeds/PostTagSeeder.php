<?php

use Illuminate\Database\Seeder;
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
        $posts = Post::all();
        $tags = count(Tag::all());

        // cycle every post
        foreach ($posts as $post) {
            // add a new tag three times
            for ($i=0; $i < 3; $i++) {
                $tagNew = rand(1, $tags);
                // add first tag
                if ($i === 0) {
                    $post->tags()->attach($tagNew);
                } else {
                    // cycle every tag of that post
                    foreach ($post->tags as $tag) {
                        // check that the post doesn't have that tag already
                        if ($tag->id !== $tagNew) {
                            $post->tags()->attach($tagNew);
                        }
                    }
                }
            }
        }
    }
}
