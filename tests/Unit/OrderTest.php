<?php

namespace Tests\Unit;

use App\Facades\Cart;
use App\Item;
use App\Order;
use App\Sale;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_retrieve_user_id_from_strip_email()
    {
        $data = $this->stripeData();

        $user = factory(User::class)->create(['id' => 9, 'email' => $data['stripeEmail']]);
        $order = factory(Order::class)->create();
        $this->assertNotEquals($user->id, $order->user_id);

        $order->setUserIdFromStripe($data);

        $this->assertEquals($user->id, $order->user_id);
    }

    /** @test */
    public function it_should_create_a_user_if_not_found_and_assign_to_order()
    {
        $data = $this->stripeData();
        $order = factory(Order::class)->create();

        $this->assertEquals(0, User::count());

        $order->setUserIdFromStripe($data);

        $this->assertEquals(1, $order->user_id);
        $this->assertEquals(1, User::count());
    }

    /** @test */
    public function it_should_store_many_sales()
    {
        $order = factory(Order::class)->make();

        $data = [
            1 => [
                'item_id' => 1,
                'description' => 'some text',
                'qty' => 2,
                'price_dollars' => '230'
            ],
            2 => [
                'item_id' => 2,
                'description' => 'some text for second item.',
                'qty' => 1,
                'price_dollars' => '220'
            ]
        ];

        $order->save();
        $order->sales()->createMany($data);

        $this->assertCount(2, $order->sales->toArray());
    }

    /** @test */
    public function it_should_be_create_user_order_and_sale_from_stripe()
    {
        $this->buildCart();

        $data = $this->stripeData();

        $this->assertEquals(0, User::count());
        $this->assertEquals(0, Order::count());
        $this->assertEquals(0, Sale::count());

        $order = Order::createFromStripe($data);

        $this->assertEquals(1, User::count());
        $this->assertEquals(1, Order::count());
        $this->assertEquals(2, Sale::count());
        $this->assertEquals(30, $order->total_dollars);
        $this->assertTrue($order->fresh()->isNew());
    }

    /** @test */
    public function it_should_add_item_back_to_stock_when_ordering_it()
    {
        $this->buildCart();

        $item = Item::first(); // Get first created item from cart built
        $this->assertEquals(1, $item->qty);

        $order = Order::createFromStripe($this->stripeData());

        $this->assertEquals(0, $item->fresh()->qty);
        $this->assertCount(2, $order->sales);

        $order->delete();

        $this->assertEquals(0, Sale::count());

        $this->assertEquals(1, $item->fresh()->qty);
    }
}
