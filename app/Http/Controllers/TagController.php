<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    const VIEW = 'admin.tags.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Tag::latest('id')->paginate(5);
        return view(self::VIEW.__FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::VIEW.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('tags')
            ],
        ]);

        try {
            Tag::query()->create($data);
            return redirect()->route('tags.index')->with('msg', 'Created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view(self::VIEW.__FUNCTION__, compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('tags')->ignore($tag->id)
            ],
        ]);

        try {
            $tag->update($data);
            return redirect()->route('tags.index')->with('msg', 'Updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return redirect()->route('tags.index')->with('msg', 'Deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }
}
