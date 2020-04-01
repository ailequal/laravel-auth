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
        $tags = [
            'Adventure',
            'Sport',
            'Movie',
            'Car',
            'Web',
            'Tech',
            'Food',
            'Music',
            'Book'
        ];

        foreach ($tags as $name) {
            $tag = new Tag;
            $tag->name = $name;
            $tag->save();
        }
    }
}
