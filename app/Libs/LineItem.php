<?php

namespace App\Libs;

use App\Item;

/**
 * Wrapper for a cart item.
 */
class LineItem
{
    public $item = null;
    public $qty = 1;
    public function __construct(Item $item, $qty = 1)
    {
        $this->item = $item;
        $this->qty = $qty;
    }

    public function add($qty)
    {
        $this->qty += $qty;
    }

    public function change($qty)
    {
        $this->qty = $qty;
    }
}