<?php

namespace Tests\Unit;

use App\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_find_published_posts()
    {
        $post = $this->create('App\Post', ['is_published' => true, 'published_at' => date('Y-m-d')]);
        $post2 = $this->create('App\Post', ['is_published' => true, 'published_at' => Carbon::now()->addDays(1)]); // Future publish
        $post3 = $this->create('App\Post', ['is_published' => false, 'published_at' => Carbon::now()->subDay()]); // Yesterday, but not published

        $result = Post::published()->get();

        $this->assertCount(1, $result);
        $this->assertEquals($result[0]->id, $post->id); // Only Post.
    }

    /** @test */
    public function it_will_order_latest_by_published_date()
    {
        $post2 = $this->create('App\Post', ['is_published' => true, 'published_at' => Carbon::now()->subDay()]); // Yesterday, ordered last
        $post3 = $this->create('App\Post', ['is_published' => true, 'published_at' => Carbon::now()->addDays(5)]); // Future, ordered first.


        $result = Post::latest()->get();
        $this->assertEquals($result[0]->id, $post3->id);
        $this->assertEquals($result[1]->id, $post2->id);
    }

    /** @test */
    public function it_can_be_published()
    {
        $post = $this->create('App\Post', ['is_published' => true, 'published_at' => Carbon::now()->addDay()]);

        $this->assertFalse($post->isPublished());

        $post->published_at = Carbon::now()->subDay();
        $post->save();

        $this->assertTrue($post->isPublished());
    }

    /** @test */
    public function it_cannot_be_viewed_if_not_active()
    {
        $post = $this->create('App\Post', ['is_published' => false, 'published_at' => Carbon::now()->subDay()]);

        $this->assertTrue($post->isPublished());
        $this->assertFalse($post->isViewable());
    }

    /** @test */
    public function it_cannot_be_viewed_if_not_published()
    {
        $post = $this->create('App\Post', ['is_published' => true, 'published_at' => Carbon::now()->addDay()]);

        $this->assertTrue($post->isActive());
        $this->assertFalse($post->isViewable());
    }
}
