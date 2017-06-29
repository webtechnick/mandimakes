<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderShipped;
use App\Http\Controllers\Controller;
use App\Order;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class AdminOrdersController extends Controller
{
    use Flashes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::latest();
        if ($filter = $request->input('q')) {
            $query->filter($filter);
        }
        $orders = $query->paginate();
        return view('admin.orders.index',compact('orders', 'filter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order->seen()->save(); // Mark order as seen.

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());

        if ($order->hasTracking()) {
            $order->status = 4; //shipped;
            $order->save();
            event(new OrderShipped($order));
        }

        $this->goodFlash('Order updated.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        $this->goodFlash('Order deleted.');

        return redirect()->route('admin.orders');
    }
}
