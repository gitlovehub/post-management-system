<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    const VIEW = 'admin.posts.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('posts')
            ->select(
                'posts.id',
                'posts.title',
                'posts.excerpt',
                'posts.description',
                'posts.view',
                'posts.image',
                'posts.status',
                'posts.user_id',
                'posts.category_id',
                'posts.created_at',
                'posts.updated_at',
                'users.name as author_name',
                DB::raw('GROUP_CONCAT(tags.name SEPARATOR ", ") AS tag_name')
            )
            ->leftJoin('post_tags', 'posts.id', '=', 'post_tags.post_id')
            ->leftJoin('tags', 'post_tags.tag_id', '=', 'tags.id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->groupBy('posts.id', 'users.name')
            ->latest('posts.id')
            ->paginate(5);
    
        return view(self::VIEW.__FUNCTION__, compact('data'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $user_name  = Auth::user()->name;
        $user_id    = Auth::id();
        $tags       = Tag::all();
        return view(self::VIEW.__FUNCTION__, compact('categories', 'tags', 'user_id', 'user_name'));
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
            'excerpt'       => 'required|max:255',
            'description'   => 'required|max:65000',
            'image'         => 'required|image|max:2048',
            'status' => [
                'required',
                'string',
                Rule::in(['draft', 'published'])
            ],
            'user_id'       => 'required|exists:users,id',
            'category_id'   => 'required|exists:categories,id',
            'tags'          => 'array',
            'tags.*'        => 'exists:tags,id'
        ]);

        try {
            // Xử lý upload hình ảnh
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('posts', $request->file('image'));
            }
            
            // Tạo bài viết
            $post = Post::query()->create($data);

            // Gắn tags vào bài viết
            if ($request->has('tags')) {
                $post->tags()->attach($request->tags); // Giả sử bạn đã thiết lập mối quan hệ giữa Post và Tag
            }
            return redirect()->route('posts.index')->with('msg', 'Created successfully.');
        } catch (\Throwable $e) {
            if (!empty($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $category = $post->category;
        return view(self::VIEW.__FUNCTION__, compact('post', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags       = Tag::all();
        return view(self::VIEW.__FUNCTION__, compact('post', 'categories', 'tags'));
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
            'excerpt'       => 'required|max:255',
            'description'   => 'required|max:65000',
            'image'         => 'nullable|image|max:2048',
            'status' => [
                'required',
                'string',
                Rule::in(['draft', 'published'])
            ],
            'category_id'   => 'required|exists:categories,id',
            'tags'          => 'array',
            'tags.*'        => 'exists:tags,id'
        ]);

        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('posts', $request->file('image'));
            }

            $currentImg = $post->image;

            $post->update($data);

            if ($request->hasFile('image') && !empty($currentImg) && Storage::exists($currentImg)) {
                Storage::delete($currentImg);
            }

            // Đồng bộ các tags
            if ($request->has('tags')) {
                $post->tags()->sync($request->input('tags'));
            } else {
                // Nếu không có tags được chọn, xóa tất cả các tags liên quan
                $post->tags()->sync([]);
            }

            return redirect()->route('posts.index')->with('msg', 'Updated successfully.');
        } catch (\Throwable $e) {
            if (!empty($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            if (!empty($post->image) && Storage::exists($post->image)) {
                Storage::delete($post->image);
            }
            return redirect()->route('posts.index')->with('msg', 'Deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }
}
