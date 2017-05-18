<?php

namespace Tests\Unit;

use App\Item;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_incriment_cart_count()
    {
        $item = factory(Item::class)->create();

        $this->assertEquals(0, $item->cart_count);

        $item->incrimentCart();

        $this->assertEquals(1, $item->cart_count);
    }
}
