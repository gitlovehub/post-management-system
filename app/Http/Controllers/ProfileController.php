<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        Cache::put('user-is-online-' . auth()->user()->id, true, now()->addMinutes(5));
        
        $query = DB::table('posts as p')
        ->join('categories as c', 'p.category_id', '=', 'c.id')
        ->join('users as u', 'p.user_id', '=', 'u.id')
        ->select('p.id', 'p.title', 'p.excerpt', 'p.view', 'p.image', 'p.status', DB::raw('DATE_FORMAT(p.created_at, "%d %b %Y") as created_at'), 'c.id as category_id', 'c.name as category_name')
        ->where('user_id', $user->id);

        $posts = (clone $query)
            ->orderBy('p.created_at', 'desc')
            ->get();
        
        $categories = Category::all();
        $tags       = Tag::all();

        return view('client.profile', compact('user', 'posts', 'categories', 'tags'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'avatar' => 'nullable|image|max:2048'
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $data['avatar'] = Storage::put('users', $request->file('avatar'));
            } else {
                $currentImg = $user->avatar;
            }

            $user->update($data);

            if ($request->hasFile('avatar') && !empty($currentImg) && Storage::exists($currentImg)) {
                Storage::delete($currentImg);
            }

            return redirect()->route('client.profile')->with('msg', 'Profile updated successfully!');
        } catch (\Throwable $e) {
            if (!empty($data['avatar']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avatar']);
            }
            return redirect()->back()->with('msg', false);
        }
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags       = Tag::all();
        return view('client.partials.modal', compact('post', 'categories', 'tags'));
    }

    public function updatePost(Request $request, Post $post)
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

}
