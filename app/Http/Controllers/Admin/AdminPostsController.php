<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class AdminPostsController extends Controller
{
    use Flashes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Post::latest();
        if ($filter = $request->input('q')) {
            $query->filter($filter);
        }
        $posts = $query->paginate();

        return view('admin.posts.index', compact('posts','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Preview a post.
     * @param  Post   $post [description]
     * @return [type]       [description]
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = Post::createFromRequest($request->all());
        $this->goodFlash('Post created');

        return redirect()->route('admin.posts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());

        $this->goodFlash('Post Updated');
        return redirect()->route('admin.posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        $this->goodFlash('Post deleted.');

        return redirect()->route('admin.posts');
    }

    /**
     * Toggle the publish of the post
     * @param  Post   $post [description]
     * @return [type]       [description]
     */
    public function toggle(Post $post)
    {
        $post->togglePublished();

        $this->goodFlash('Post Toggled.');

        return back();
    }
}
