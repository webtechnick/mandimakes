<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
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

        $items = $query->paginate();
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
        return view('items.show', compact('item'));
    }
}
