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
    public function it_should_remove_associations_when_deleted()
    {
        $item = $this->create(Item::class);
        $tag = $this->create(Tag::class);

        $item->addTag($tag);

        $this->assertEquals(1, $item->tags()->count());

        $tag->delete();

        $this->assertEquals(0, $item->fresh()->tags()->count()); // removed association
    }
}
