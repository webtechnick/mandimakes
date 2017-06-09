<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Tag;
use App\Traits\Flashes;
use Illuminate\Http\Request;

class AdminTagsController extends Controller
{
    use Flashes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Tag::orderBy('name', 'asc');
        if ($filter = $request->input('q')) {
            $query->filter($filter);
        }
        $tags = $query->paginate();

        return view('admin.tags.index', compact('tags','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->all());
        $this->goodFlash('Tag created');

        return redirect()->route('admin.tags');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->fill($request->all())->save();

        $this->goodFlash('Tag Updated');
        return redirect()->route('admin.tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        $this->goodFlash('Tag deleted.');
        return redirect()->route('admin.tags');
    }
}
