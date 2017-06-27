<?php

namespace App\Http\Controllers;

use App\Events\OrderSuccess;
use App\Facades\Cart;
use App\Order;
use App\Traits\Flashes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    use Flashes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::myOrders()->latest()->paginate();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Cart::isEmpty()) {
            $this->badFlash('Nothing in shopping cart, please add some items');
            return redirect()->route('items');
        }
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::createFromStripe($request->all());
        $order->charge();

        if ($order->isGood()) {
            event(new OrderSuccess($order));
            Cart::clear();
            $this->goodFlash('Thank you for your purchase.');
            return redirect()->route('myorders');
        }

        $this->badFlash('Unable to complete purchase. ' . $order->stripeOutcome);
        return redirect()->route('checkout');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
