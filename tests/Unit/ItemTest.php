<?php

namespace Tests\Unit;

use App\Item;
use App\Photo;
use App\Tag;
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

    /** @test */
    public function it_should_retrieve_items_with_tags()
    {
        $item = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();
        $tag = factory(Tag::class)->create(['name' => 'Tag', 'slug' => 'tag']);
        $tag2 = factory(Tag::class)->create(['name' => 'Tag2', 'slug' => 'tag2']);
        $tag3 = factory(Tag::class)->create(['name' => 'Tag3', 'slug' => 'tag3']); // not assigned

        $item->addTag($tag);
        $item->addTag($tag2);
        $item2->addTag($tag2);


        $items = Item::byTags(['tag2'])->get();
        $this->assertCount(2, $items); // should get both
        foreach ($items as $it) {
            $tags = $it->tags->pluck('slug');
            $this->assertTrue(in_array('tag2', $tags->toArray()));
        }

        $items = Item::byTags(['tag'])->get();
        $this->assertCount(1, $items); // should only get one

        $items = Item::byTags(['tag', 'tag2'], true)->get();
        $this->assertCount(1, $items); // should only get one

        $items = Item::byTags(['tag', 'tag2', 'tag3'], true)->get();
        $this->assertCount(0, $items); // should get none

        $items = Item::byTags(['tag', 'tag2', 'tag3'])->get();
        $this->assertCount(2, $items); // should get two
    }

    /** @test */
    public function it_should_fill_in_short_description()
    {
        $item = new Item([
            'title' => 'Some Title',
            'description' => 'This is a description'
        ]);

        $item->save();

        $this->assertEquals($item->short_description, $item->description);
    }

    /** @test */
    public function it_should_have_a_primary_photo()
    {
        $item = $this->create(Item::class);
        $photo = $this->create(Photo::class, ['item_id' => '9']);
        $photo2 = $this->create(Photo::class, ['item_id' => '9']);

        $this->assertFalse($photo->isPrimary());
        $this->assertFalse($photo2->isPrimary());

        $item->addPhoto($photo);
        $item->addPhoto($photo2);

        $this->assertTrue($photo->isPrimary());
        $this->assertFalse($photo2->isPrimary());

        $this->assertEquals($photo->id, $item->primaryPhoto->id);
    }

    /** @test */
    public function it_should_have_statuses()
    {
        $item = $this->create(Item::class);

        $this->assertTrue($item->isStatus('available'));
        $this->assertFalse($item->isStatus('unavailable'));

        $item->setStatus('unavailable');

        $this->assertFalse($item->isStatus('available'));
        $this->assertTrue($item->isStatus('unavailable'));

    }

    /** @test */
    public function it_should_decide_if_it_has_a_primary_photo()
    {
        $item = $this->create(Item::class);

        $this->assertFalse($item->hasPrimaryPhoto());

        $photo = $this->create(Photo::class);
        $item->addPhoto($photo);

        $this->assertTrue($item->fresh()->hasPrimaryPhoto());
    }

    /** @test */
    public function it_should_return_a_url()
    {
        $item = $this->create(Item::class);

        $this->assertContains('/item/1', $item->url());
    }

    /** @test */
    public function it_should_know_its_admin_url()
    {
        $item = $this->create(Item::class);

        $this->assertContains('/admin/items/edit/1', $item->adminUrl());
    }
}
