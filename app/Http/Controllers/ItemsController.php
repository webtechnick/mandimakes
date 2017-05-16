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
    public function index($searchterm = null)
    {
        $query = Item::latest();

        $items = $query->paginate();
        return view('items.index', compact('items','searchterm'));
    }

    /**
     * Accept a search post.
     * @return [type] [description]
     */
    public function search(Request $request)
    {
        if ($term = $request->input('term')) {
            return $this->index($term);
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        Cart::add($item);
        return view('items.show', compact('item'));
    }
}
