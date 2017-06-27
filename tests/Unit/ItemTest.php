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

    /** @test */
    public function it_should_sync_tags_by_string_by_creating()
    {
        $item = $this->create(Item::class);
        $this->assertEquals(0, Tag::count());

        $tagString = 'Dragon,Egg,Stuff';

        $item->syncTagString($tagString);

        $this->assertEquals($item->tagString, $tagString);
        $this->assertCount(3, $item->tags()->get());
        $this->assertEquals(3, Tag::count());
    }

    /** @test */
    public function it_should_sync_tags_by_string_by_finding_tags()
    {
        $item = $this->create(Item::class);
        factory(Tag::class)->create(['name' => 'Dragon']);
        factory(Tag::class)->create(['name' => 'Egg']);
        factory(Tag::class)->create(['name' => 'Stuff']);
        $this->assertEquals(3, Tag::count());

        $tagString = 'Dragon,Egg,Stuff';

        $item->syncTagString($tagString);

        $this->assertEquals($item->tagString, $tagString);
        $this->assertCount(3, $item->tags()->get());
        $this->assertEquals(3, Tag::count()); // Didn't create any new tags
    }

    /** @test */
    public function it_should_clear_all_new_tags()
    {
        $item = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();
        $tag = factory(Tag::class)->create(['name' => 'New', 'slug' => 'new']);

        $item->addTag($tag);
        $item2->addTag($tag);

        $this->assertEquals('New', $item->tagString);

        Item::clearNew();

        $this->assertEquals('', $item->fresh()->tagString);
        $this->assertEquals('', $item2->fresh()->tagString);
    }

    public function it_should_have_related_items()
    {
        $item = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();
        $tag = factory(Tag::class)->create(['name' => 'Tag', 'slug' => 'tag']);
        $tag2 = factory(Tag::class)->create(['name' => 'Tag2', 'slug' => 'tag2']);
        $tag3 = factory(Tag::class)->create(['name' => 'Tag3', 'slug' => 'tag3']);

        $item->addTag($tag);
        $item->addTag($tag2);
        $item2->addTag($tag2);
        $item2->addTag($tag3);

        $related = $item->related(1); // get me item2

        $this->assertCount(1, $related);
        $this->assertEquals($related[0]->id, $item2->id);
    }

    /** @test */
    public function it_can_increase_in_stock()
    {
        $item = factory(Item::class)->create();

        $this->assertEquals(1, $item->qty);

        $item->increaseStock(2);

        $this->assertEquals(3, $item->qty);
    }

    /** @test */
    public function it_can_decrease_in_stock()
    {
        $item = factory(Item::class)->create();

        $this->assertEquals(1, $item->qty);

        $item->reduceStock(1);

        $this->assertEquals(0, $item->qty);
    }

    /** @test */
    public function it_cannot_decrease_past_zero()
    {
        $item = factory(Item::class)->create();

        $this->assertEquals(1, $item->qty);

        $item->reduceStock(10);

        $this->assertEquals(0, $item->qty);
    }
}
