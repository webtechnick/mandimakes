<?php

namespace Tests\Unit;

use App\Facades\Cart;
use App\Item;
use App\Sale;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_build_sales_data_from_cart()
    {
        $item = factory(Item::class)->create(['price_dollars' => '10']);
        $item2 = factory(Item::class)->create(['price_dollars' => '10']);

        Cart::addToCart($item);
        Cart::addToCart($item2, 2);

        $data = Sale::buildSalesFromCart();

        $this->assertEquals($data[1]['price_dollars'], '10');
        $this->assertEquals($data[1]['qty'], '1');
        $this->assertEquals($data[1]['description'], $item->short_description);
        $this->assertEquals($data[1]['item_id'], $item->id);

        $this->assertEquals($data[2]['price_dollars'], '20');
        $this->assertEquals($data[2]['qty'], '2');
        $this->assertEquals($data[2]['description'], $item2->short_description);
        $this->assertEquals($data[2]['item_id'], $item2->id);
    }
}
