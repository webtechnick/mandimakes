<?php

namespace Tests\Unit;

use App\Photo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_make_primary()
    {
        $photo = factory(Photo::class)->create();

        $this->assertFalse($photo->isPrimary());

        $photo->makePrimary();

        $this->assertTrue($photo->isPrimary());
    }
}
