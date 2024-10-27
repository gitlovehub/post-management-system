<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const VIEW = 'client.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $query = DB::table('posts as p')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.title', 'p.excerpt', 'p.view', 'p.image', DB::raw('DATE_FORMAT(p.created_at, "%d %b %Y") as created_at'), 'c.id as category_id', 'c.name as category_name', 'u.name as author')
            ->where('p.status', 'published');

        $latestPost = (clone $query)
            ->latest('p.created_at')
            ->first();

        $latestPostId = $latestPost ? $latestPost->id : null;

        $asidePosts = (clone $query)
            ->when($latestPostId, function ($query) use ($latestPostId) {
                return $query->where('p.id', '!=', $latestPostId);
            })
            ->orderBy('p.created_at', 'desc')
            ->limit(3)
            ->get();

        $mostViewed = (clone $query)
            ->orderBy('p.view', 'desc')
            ->limit(8)
            ->get();
        
        return view(self::VIEW . __FUNCTION__, compact('latestPost', 'asidePosts', 'mostViewed'));
    } 

    public function cate($id) {
        $query = DB::table('posts as p')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.title', 'p.excerpt', 'p.view', 'p.image', DB::raw('DATE_FORMAT(p.created_at, "%d %b %Y") as created_at'), 'c.id as category_id', 'c.name as category_name', 'u.name as author')
            ->where('p.status', 'published');

        $data = (clone $query)
            ->where('p.category_id', '=', $id)
            ->orderBy('p.created_at', 'desc')
            ->paginate(4);

        $categoryName = DB::table('categories')
            ->where('id', $id)
            ->value('name');

        return view(self::VIEW.__FUNCTION__, compact('data', 'categoryName'));
    }    

    public function post($id) {
        DB::table('posts')
            ->where('id', $id)
            ->increment('view');

        $post = DB::table('posts as p')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.title', 'p.excerpt', 'p.description', 'p.image', DB::raw('DATE_FORMAT(p.created_at, "%d %b %Y") as created_at'), 'c.id as category_id', 'c.name as category_name', 'u.name as author') // Get category and author
            ->where('p.id', $id)
            ->where('p.status', 'published')
            ->first();

        $comments = DB::table('comments')
            ->where('post_id', $id)
            ->where('status', 'published')
            ->select('id', 'name', 'email', 'comment', 'status', 'post_id', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view(self::VIEW.__FUNCTION__, compact('post', 'comments'));
    }

    public function search(Request $request) {
        $kw = $request->input('search');

        $query = DB::table('posts as p')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->select('p.id', 'p.title', 'p.excerpt', 'p.view', 'p.image', DB::raw('DATE_FORMAT(p.created_at, "%d %b %Y") as created_at'), 'c.id as category_id', 'c.name as category_name', 'u.name as author')
            ->where('p.status', 'published');

        $data = (clone $query)
            ->where('p.title', 'LIKE', '%' . $kw . '%')
            ->orderBy('p.created_at', 'desc')
            ->get();

        $mostViewed = (clone $query)
            ->orderBy('p.view', 'desc')
            ->limit(5)
            ->get();

        return view(self::VIEW.__FUNCTION__, compact('data', 'mostViewed', 'query', 'kw'));
    }
}
