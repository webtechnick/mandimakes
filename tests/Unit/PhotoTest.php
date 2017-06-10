<?php

namespace Tests\Unit;

use App\Photo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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

    /** @test */
    public function it_should_resize_photo()
    {
        // Cleanup first, incase there was failure.
        $this->realPhotoCleanup();

        $photo = $this->createRealPhoto();

        $this->assertFalse(File::exists(public_path('uploads/photos/200xbasic.jpg')));

        $path = $photo->thumbnail(200);

        $this->assertTrue(File::exists(public_path('uploads/photos/200xbasic.jpg')));
        $this->assertEquals('/uploads/photos/200xbasic.jpg', $path);

        // Repeat should not attempt to create a new thumbnail, use one already there.
        Image::shouldReceive('make')->never();
        $path = $photo->thumbnail(200);

        // Cleanup
        $this->realPhotoCleanup();
    }

    /** @test */
    public function it_should_delete_photos_when_deleting_photo()
    {
        $photo = $this->createRealPhoto();

        $path = $photo->thumbnail(200);

        $this->assertTrue(File::exists(public_path('uploads/photos/200xbasic.jpg')));
        $this->assertTrue(File::exists(public_path('uploads/photos/basic.jpg')));

        $photo->delete();

        $this->assertFalse(File::exists(public_path('uploads/photos/200xbasic.jpg')));
        $this->assertFalse(File::exists(public_path('uploads/photos/basic.jpg')));
    }

    public function createRealPhoto()
    {
        File::copy(base_path('tests/assets/basic.jpg'), public_path('uploads/photos/basic.jpg'));
        $photo = $this->create('App\Photo', ['name' => 'basic.jpg', 'path' => 'uploads/photos/basic.jpg']); // This file exists.
        return $photo;
    }

    public function realPhotoCleanup()
    {
        File::delete(public_path('uploads/photos/basic.jpg'));
        File::delete(File::glob(public_path('uploads/photos/*xbasic.jpg')));
    }
}
