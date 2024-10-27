<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $totalCategories = Category::count();
        $totalPosts = Post::count();
        $totalUsers = User::count();

        $totalViews = Post::sum('view');

        // Lấy số lượng bài viết trong 7 ngày qua
            $postsPerDay = Post::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Tạo mảng cho dữ liệu biểu đồ
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = $date;
            $data[] = $postsPerDay->get($date, 0); // Nếu không có dữ liệu thì mặc định là 0
        }

        return view('admin.dashboard.index', [
            'totalCategories'   => $totalCategories,
            'totalPosts'        => $totalPosts,
            'totalUsers'        => $totalUsers,
            'totalViews'        => $totalViews,
            'postsLabels'       => json_encode($labels),
            'postsData'         => json_encode($data)
        ]);
    }
}
