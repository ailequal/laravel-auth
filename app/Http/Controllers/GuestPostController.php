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
}
