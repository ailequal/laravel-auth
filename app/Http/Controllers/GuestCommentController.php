<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class GuestCommentController extends Controller
{
    private $commentValidation = [
        'name' => 'required|string|max:100',
        'email' => 'required|string|max:100',
        'text' => 'required|string',
        'post_id' => 'required|numeric'
    ];

    public function store(Request $request)
    {
        // store all the data passed with post method
        $data = $request->all();
 
        // form validation with laravel for the post data
        $request->validate($this->commentValidation);

        // creating a new object to store inside the db
        $comment = new Comment();
        $comment->fill($data);

        // post_id value recieved
        $postId = $data['post_id'];

        // retrieve all the posts from the db
        $posts = Post::all();
        $find = false;
        // cycle every post
        foreach ($posts as $post) {
            // check that the post_id alredy exist as post
            if ($post->id == $postId) {
                // save the post_id
                $comment->post_id = $postId;
                $find = true;
            }
        }
        if (!$find) {
            abort('500');
        }
 
        // if the save process was successful show the new comment
        $save = $comment->save();
        if ($save) {
            return redirect()->route('guest.posts.show', $comment->post->slug);
        } else {
            abort('500');
        }
    }
}
