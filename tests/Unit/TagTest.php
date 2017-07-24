<?php

namespace Tests\Unit;

use App\Item;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_will_return_featured()
    {
        $tag = $this->create(Tag::class, ['is_featured' => true]);

        $result = Tag::featured();

        $this->assertEquals($tag->name, $result->name);
    }

    /** @test */
    public function it_can_be_featured()
    {
        $tag = $this->create(Tag::class);

        $this->assertFalse(!!$tag->is_featured);

        $tag->setFeatured();

        $this->assertTrue($tag->fresh()->is_featured);
    }

    /** @test */
    public function only_one_can_be_featured()
    {
        $tag = $this->create(Tag::class, ['is_featured' => true]);
        $tag2 = $this->create(Tag::class, ['is_featured' => false]);

        $this->assertTrue($tag->is_featured);

        $tag2->setFeatured();

        $this->assertFalse(!!$tag->fresh()->is_featured);
        $this->assertTrue($tag2->fresh()->is_featured);
    }

    /** @test */
    public function it_should_remove_associations_when_deleted()
    {
        $item = $this->create(Item::class);
        $tag = $this->create(Tag::class);
        $tag2 = $this->create(Tag::class);

        $item->addTag($tag);
        $item->addTag($tag2);

        $this->assertEquals(2, $item->tags()->count());

        $tag->delete();

        $this->assertEquals(1, $item->fresh()->tags()->count()); // removed association
    }

    /** @test */
    public function it_can_merge_two_tags()
    {
        $item = $this->create(Item::class);
        $item2 = $this->create(Item::class);
        $tag = $this->create(Tag::class);
        $tag2 = $this->create(Tag::class);

        $item->addTag($tag);
        $item->addTag($tag2); // Item has two tags.
        $item2->addTag($tag2);

        //Tag::mergeTags($tag, $tag2); // Merging $tag2 into $tag
        $tag->merge($tag2);

        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
        $this->assertDatabaseHas('item_tag', ['tag_id' => $tag->id]);

        $this->assertDatabaseMissing('tags', ['id' => $tag2->id]);
        $this->assertDatabaseMissing('item_tag', ['tag_id' => $tag2->id]);

        // The only tag for $item2 is now $tag
        $this->assertEquals($item2->tags()->first()->id, $tag->id);
    }
}
