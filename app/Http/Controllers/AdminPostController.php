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
        if (empty($tags)) {
            abort('500');
        }

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
        $post->title = $data['title'];
        $post->text = $data['text'];
        $post->slug = Str::finish(Str::slug($post->title), '-' . rand(1, 1000));
        // $post->fill($data);

        // check that the user uploaded an image
        if (isset($data['path_image'])) {
            // save the image received
            $post->path_image = Storage::disk('public')->put('images', $data['path_image']);
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
            return redirect()->back()->withInput();
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
        if (empty($post)) {
            abort('404');
        }

        // show the selected post
        return view('admin.posts.show', ["post"=>$post]);
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
        if (empty($post)) {
            abort('404');
        }

        // requesting all the tags from the db
        $tags = Tag::all();
        if (empty($tags)) {
            abort('500');
        }

        // data value to be passed
        $data = [
            'post' => $post,
            'tags' => $tags
        ];

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // go to edit with selected post
        return view('admin.posts.edit', $data);
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
        if (empty($post)) {
            abort('404');
        }

        // update post with new data
        $post->title = $data['title'];
        $post->text = $data['text'];
        $post->slug = Str::finish(Str::slug($post->title), '-' . rand(1, 1000));
        // $post->fill($data);

        // if a new image was submitted
        if (isset($data['path_image'])) {
            // delete old image stored
            Storage::disk('public')->delete($post->path_image);
            // save the image received
            $post->path_image = Storage::disk('public')->put('images', $data['path_image']);
        }

        // update the edited post
        $update = $post->update();
        // $post->updated_at = Carbon::now();

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

        // if the update process was successful show the edited post
        if ($update) {
            return redirect()->route('admin.posts.show', $post->slug);
        } else {
            return redirect()->back()->withInput();
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
        if (empty($post)) {
            abort('404');
        }

        // check if user has post_id
        if (Auth::id() !== $post->user_id) {
            abort('500');
        }

        // detach tags from post
        $post->tags()->detach();

        // delete the image file linked to path_image
        Storage::disk('public')->delete($post->path_image);

        // delete the selected post from the db
        $delete = $post->delete();

        // if the delete process was successful redirect to route index
        if ($delete) {
            return redirect()->route('admin.posts.index');
        } else {
            abort('500');
        }
    }
}
