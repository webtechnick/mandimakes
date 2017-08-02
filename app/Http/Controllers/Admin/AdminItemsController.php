<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class AdminItemsController extends Controller
{
    use Flashes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Item::latest();
        if ($filter = $request->input('q')) {
            $query->filter($filter);
        }
        $items = $query->paginate();

        return view('admin.items.index', compact('items','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = Item::createFromRequest($request->all());
        $this->goodFlash('Item created');

        return redirect()->route('admin.items.edit', $item)->with(['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, Item $item)
    {
        $item->updateFromRequest($request->all());

        $this->goodFlash('Item Updated');
        return redirect()->route('admin.items');
    }

    /**
     * Clear the new from all items.
     * @return [type] [description]
     */
    public function clear_new()
    {
        Item::clearNew();
        $this->goodFlash('New Items Cleared');
        return back();
    }

    /**
     * Toggle the item new status
     * @param  Item   $item [description]
     * @return [type]       [description]
     */
    public function toggle_new(Item $item)
    {
        $item->toggleNew();

        if ($item->isNew()) {
            $message = 'Item is now marked as new.';
        } else {
            $message = 'Item is no longer marked as new.';
        }
        $this->goodFlash($message);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        $this->goodFlash('Item deleted.');

        return redirect()->route('admin.items');
    }
}
