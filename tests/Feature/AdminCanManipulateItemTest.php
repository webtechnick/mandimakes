<?php

namespace Tests\Feature;

use App\Item;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AdminCanManipulateItemTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_should_be_able_to_create_item_with_tags()
    {
        $this->signInAdmin();
        $data = [
            'title' => 'New Item',
            'status' => 1,
            'price_dollars' => 12,
            'qty' => 1,
            'description' => 'Description',
            'tagString' => 'Dragon,Egg'
        ];

        $this->assertEquals(0, Item::count());
        $this->assertEquals(0, Tag::count());

        $response = $this->post('/admin/items', $data);

        $response->assertSessionMissing('errors');

        $this->assertEquals(1, Item::count());
        $this->assertEquals(2, Tag::count());
    }
}
