<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class GuestPostController extends Controller
{
    public function index() {
        // requesting all the posts from the db
        $posts = Post::all();
        return view('guest.posts.index', ["posts"=>$posts]);
    }

    public function show($slug)
    {
        // call from the db the record matching the given slug
        $post = Post::where('slug', $slug)->first();
        if (empty($post)) {
            abort('404');
        }

        // show the selected post
        return view('guest.posts.show', ["post"=>$post]);
    }
}
