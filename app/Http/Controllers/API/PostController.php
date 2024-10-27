<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('tags', 'category', 'user')->latest()->paginate(5);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('posts')
            ],
            'excerpt' => 'required|max:255',
            'description' => 'required|max:65000',
            'image' => 'required|image|max:2048',
            'status' => [
                'required',
                'string',
                Rule::in(['draft', 'published'])
            ],
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('posts', $request->file('image'));
        }

        $post = Post::create($data);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return response()->json(['message' => 'Created successfully.', 'post' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post->load('tags', 'category', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('posts')->ignore($post->id)
            ],
            'excerpt' => 'required|max:255',
            'description' => 'required|max:65000',
            'image' => 'nullable|image|max:2048',
            'status' => [
                'required',
                'string',
                Rule::in(['draft', 'published'])
            ],
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($request->hasFile('image')) {
            if (!empty($post->image) && Storage::exists($post->image)) {
                Storage::delete($post->image);
            }
            $data['image'] = Storage::put('posts', $request->file('image'));
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        } else {
            $post->tags()->sync([]);
        }

        return response()->json(['message' => 'Updated successfully.', 'post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (!empty($post->image) && Storage::exists($post->image)) {
            Storage::delete($post->image);
        }

        $post->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}
