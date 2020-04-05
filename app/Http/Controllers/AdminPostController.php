<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Post;
use App\Tag;

class AdminPostController extends Controller
{
    private $postValidation = [
        'title' => 'required|string|max:100',
        'text' => 'required|string',
        'path_image' => 'nullable|image'
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
        // requesting all the tags from the db
        $tags = Tag::all();

        // form for creating a new entry inside the db
        return view('admin.posts.create', ["tags"=>$tags]);
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
        $post->slug = Str::finish(Str::slug($post->title), '-' . rand(1, 1000));

        // check that the user uploaded an image
        if (isset($data['path_image'])) {
            // save the image received
            $path = Storage::disk('public')->put('images', $data['path_image']);
            $post->path_image = $path;
        }

        // save the new post
        $save = $post->save();

        // check that the user set some tags
        if (isset($data['tags'])) {
            $tagsSelect = $data['tags'];
            // store db tags as an array
            $tags = Tag::all();
            $tagsArray = [];
            foreach ($tags as $key => $tag) {
                $tagsArray[] = $tag->id;
            }
            // check tags
            foreach ($tagsSelect as $key => $tag) {
                if (!in_array($tag, $tagsArray)) {
                    abort('500');
                }
            }
            // save the tags for the post
            $post->tags()->attach($tagsSelect);
        }

        // if the save process was successful show the new post
        if ($save) {
            return redirect()->route('admin.posts.show', $post->slug);
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
    public function show($slug)
    {
        // call from the db the record matching the given slug
        $post = Post::where('slug', $slug)->first();

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
    public function edit($slug)
    {
        // call from the db the record matching the given slug
        $post = Post::where('slug', $slug)->first();

        // requesting all the tags from the db
        $tags = Tag::all();

        // data value to be passed
        $data = [
            'post' => $post,
            'tags' => $tags
        ];

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // if the selection process was successful go to edit with selected post
        if (!empty($post)) {
            return view('admin.posts.edit', $data);
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

        // check that the user set some tags
        if (isset($data['tags'])) {
            $tagsSelect = $data['tags'];
            // store db tags as an array
            $tags = Tag::all();
            $tagsArray = [];
            foreach ($tags as $key => $tag) {
                $tagsArray[] = $tag->id;
            }
            // check tags
            foreach ($tagsSelect as $key => $tag) {
                if (!in_array($tag, $tagsArray)) {
                    abort('500');
                }
            }
            // save the tags for the post
            $post->tags()->sync($tagsSelect);
        } else {
            $post->tags()->detach();
        }

        // if the selection process was successful
        if (!empty($post)) {
            // if a new image was submitted
            if (isset($data['path_image'])) {
                // delete old image stored
                Storage::disk('public')->delete($post->path_image);
            }
            // patch the object stored inside the db matching the id
            $post->update($data);
            $slug = Str::finish(Str::slug($post->title), '-' . rand(1, 1000));
            $post->slug = $slug;
            // check that the user uploaded an image
            if (isset($data['path_image'])) {
                // save the image received
                $path = Storage::disk('public')->put('images', $data['path_image']);
                $post->path_image = $path;
            }
            $post->updated_at = Carbon::now();
            $post->update();
            return redirect()->route('admin.posts.show', $post->slug);
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
    public function destroy($slug)
    {
        // call from the db the record matching the given slug
        $post = Post::where('slug', $slug)->first();

        // detach tags from post
        $post->tags()->detach();

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // delete the image file linked to path_image
        Storage::disk('public')->delete($post->path_image);

        // select post matching id from db and delete it
        $post->delete();

        // redirect to route index
        return redirect()->route('admin.posts.index');
    }
}
