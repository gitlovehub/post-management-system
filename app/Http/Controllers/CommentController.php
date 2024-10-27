<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    const VIEW = 'admin.comments.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Comment::latest('id')->paginate(5);
        return view(self::VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
    {
        // Xác thực dữ liệu đầu vào
        $data = $request->validate([
            'comment' => 'required|string|max:500'
        ]);

        $data['post_id'] = $postId;

        try {
            // Kiểm tra nếu người dùng đã đăng nhập
            if (Auth::check()) {
                $data['user_id']    = Auth::id();
                $data['name']       = Auth::user()->name;
                $data['email']      = Auth::user()->email;

                // Tạo bình luận mới
                Comment::create($data);

                // Tạo bản ghi trong bảng interactions
                DB::table('interactions')->insert([
                    'user_id'       => $data['user_id'],
                    'post_id'       => $postId,
                    'type'          => 'comment',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ]);
            } else {
                // Nếu chưa đăng nhập, yêu cầu nhập tên và email
                $data = array_merge($data, $request->validate([
                    'name'  => 'required|string|max:255',
                    'email' => 'required|email|max:255'
                ]));
                // Tạo bình luận mới mà không có user_id
                Comment::create($data);
            }
            return response()->json(['msg' => 'Your comment is pending approval.']);
        } catch (\Throwable $e) {
            Log::error($e);
            return response()->json(['msg' => 'Please try again.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view(self::VIEW . __FUNCTION__, compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'published'])
            ]
        ]);

        try {
            $comment->update($data);
            return redirect()->route('comments.index')->with('msg', 'Updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();
            return redirect()->route('comments.index')->with('msg', 'Deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }
}
