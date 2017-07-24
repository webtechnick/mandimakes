<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminCanClearCacheTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_clear_cache()
    {
        $this->signInAdmin();

        Cache::put('foo', 'bar', 10);

        $this->assertTrue(Cache::has('foo'));

        $this->get('/admin/clear_cache');

        $this->assertFalse(Cache::has('foo'));
    }
}
