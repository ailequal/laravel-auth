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
        // requesting all the posts from the db
        $posts = Post::all();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
