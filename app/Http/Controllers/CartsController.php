<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Item;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    /**
     * Add an item to the cart
     * @param Item    $item [description]
     * @param integer $qty  [description]
     */
    public function add(Item $item, $qty = 1)
    {
        Cart::addToCart($item, $qty);
        return redirect()->route('checkout');
    }

    /**
     * Change the quantity in a cart
     * @param  Item   $item [description]
     * @param  [type] $qty  [description]
     * @return [type]       [description]
     */
    public function changeQty(Item $item, $qty)
    {
        Cart::change($item, $qty);
        return redirect()->route('checkout');
    }

    /**
     * Clear the cart and go back to items index
     * @return [type] [description]
     */
    public function clear()
    {
        Cart::clear();
        return redirect()->route('items');
    }

    /**
     * Remove the item from the cart
     * @param  Item   $item [description]
     * @return [type]       [description]
     */
    public function remove(Item $item)
    {
        Cart::remove($item);
        return redirect()->route('checkout');
    }
}
