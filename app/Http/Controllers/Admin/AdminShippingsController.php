<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shipping;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class AdminShippingsController extends Controller
{
    use Flashes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Shipping::latest();
        if ($filter = $request->input('q')) {
            $query->filter($filter);
        }
        $shippings = $query->paginate();

        return view('admin.shippings.index', compact('shippings','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shippings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shipping = Shipping::create($request->all());
        $this->goodFlash('Shipping Created');

        return redirect()->route('admin.shippings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        return view('admin.shippings.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        $shipping->fill($request->all())->save();

        $this->goodFlash('Shipping Updated');
        return redirect()->route('admin.shippings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        $this->goodFlash('Shipping Deleted');
        return redirect()->route('admin.shippings');
    }
}
