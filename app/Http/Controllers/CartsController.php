<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Item;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    use Flashes;
    /**
     * Add an item to the cart
     * @param Item    $item [description]
     * @param integer $qty  [description]
     */
    public function add(Item $item, $qty = 1)
    {
        Cart::addToCart($item, $qty);
        $this->goodFlash('Item added to cart.');
        return redirect()->route('checkout');
    }

    /**
     * Change the quantity in a cart
     * @param  Item   $item [description]
     * @param  [type] $qty  [description]
     * @return [type]       [description]
     */
    public function change(Item $item, $qty = 1)
    {
        if (request()->input('qty')) {
            $qty = request()->input('qty');
        }
        Cart::change($item, $qty);
        $this->goodFlash('Item updated in cart.');
        return redirect()->route('checkout');
    }

    /**
     * Clear the cart and go back to items index
     * @return [type] [description]
     */
    public function clear()
    {
        Cart::clear();
        $this->goodFlash('Cart cleared.');
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
        $this->goodFlash('Item removed from cart.');
        return redirect()->route('checkout');
    }
}
