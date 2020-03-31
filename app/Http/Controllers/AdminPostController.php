<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class AdminPostController extends Controller
{
    private $postValidation = [
        'title' => 'required|string|max:100',
        'text' => 'required|string'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // requesting all the posts from the db matching the user_id
        $posts = Post::where('user_id', Auth::id())->get();
        return view('admin.posts.index', ["posts"=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // form for creating a new entry inside the db
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store all the data passed with post method
        $data = $request->all();

        // form validation with laravel for the post data
        $request->validate($this->postValidation);

        // creating a new object to store inside the db
        $post = new Post();
        $userId = Auth::user()->id;
        $post->user_id = $userId;
        $post->fill($data);

        // if the save process was successful show the new post
        $save = $post->save();
        if ($save) {
            return redirect()->route('admin.posts.show', $post->id);
        } else {
            abort('500');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // call from the db the record matching the given id
        $post = Post::where('id', $id)->first();

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // if the selection process was successful show the selected post
        if (!empty($post)) {
            return view('admin.posts.show', ["post"=>$post]);
        } else {
            abort('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // call from the db the record matching the given id
        $post = Post::where('id', $id)->first();

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // if the selection process was successful go to edit with selected post
        if (!empty($post)) {
            return view('admin.posts.edit', ["post"=>$post]);
        } else {
            abort('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // store all the data passed with patch method
        $data = $request->all();

        // form validation with laravel for the patch data
        $request->validate($this->postValidation);
        
        // find post to patch
        $post = Post::find($id);
        
        // retrieve user_id and update post with it
        $userId = Auth::user()->id;
        $post->user_id = $userId;

        // if the selection process was successful
        if (!empty($post)) {
            // patch the object stored inside the db matching the id
            $post->update($data);
            // start the show function from controller
            return redirect()->route('admin.posts.show', $post->id);
        } else {
            abort('404');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // call from the db the record matching the given id
        $post = Post::where('id', $id)->first();

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // select post matching id from db and delete it
        Post::find($id)->delete();
        
        // redirect to route index
        return redirect()->route('admin.posts.index');
    }
}
