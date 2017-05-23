<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Item;
use App\Photo;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class AdminPhotosController extends Controller
{
    use Flashes;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Item $item)
    {
        $photo = Photo::fromFileUpload($request->file('photo'));
        $item->addPhoto($photo);

        return 'Done';
    }

    /**
     * Make a photo a primary photo
     * @param  Photo  $photo [description]
     * @return [type]        [description]
     */
    public function makeprimary(Photo $photo)
    {
        $photo->makePrimary()->save();

        $this->goodFlash('Photo selected is now the item\'s primary Photo.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();

        $this->goodFlash('Photo removed.');

        return back();
    }
}
