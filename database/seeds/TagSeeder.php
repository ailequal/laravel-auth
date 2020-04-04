<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // generate all the tags inside an array
        $tags = [
            'Adventure',
            'Sport',
            'Movie',
            'Car',
            'Web',
            'Tech',
            'Food',
            'Music',
            'Book',
            'Photography'
        ];

        // cycle every tag inside the array and create an instance of tag
        foreach ($tags as $name) {
            $tag = new Tag;
            $tag->name = $name;
            $tag->save();
        }
    }
}
