<?php

namespace App\Http\Controllers;

use App\Post;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    use Flashes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->published()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (!$post->isViewable()) {
            $this->badFlash('Whoa there, have to wait for this content!');
            return redirect()->route('posts.index');
        }
        return view('posts.show', compact('post'));
    }
}
