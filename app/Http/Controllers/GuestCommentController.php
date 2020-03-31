<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // add the post_id value
        $postId = $data['post_id'];
        $comment->post_id = $postId;
 
        // if the save process was successful show the new comment
        $save = $comment->save();
        if ($save) {
            return redirect()->route('guest.posts.show', $comment->post->slug);
        } else {
            abort('500');
        }
    }
}
