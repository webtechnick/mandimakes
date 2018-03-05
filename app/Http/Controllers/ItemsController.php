<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Item;
use App\Post;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Featured page, homepage
     * @return [type] [description]
     */
    public function featured()
    {
        return redirect()->route('items');

        $items = Item::featured()->get();
        // $post = Post::mostRecent();
        return view('items.featured', compact('items', 'post'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Item::latest()->available();
        if ($filter = $request->input('q')) {
            $query->filter($filter);
        }
        if ($tags = $request->input('tags')) {
            $strict = $request->input('strict') ?: false;
            $query->byInputTags($tags, $strict);
        }

        $items = $query->paginate(9);
        return view('items.index', compact('items','filter'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $related = $item->related();
        return view('items.show', compact('item','related'));
    }
}
