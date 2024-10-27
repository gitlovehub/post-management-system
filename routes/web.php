<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware(['checkActive'])->group(function () {
    Route::get('/',                     [HomeController::class, 'index']);
    Route::get('/cate/{id}',            [HomeController::class, 'cate']);
    Route::get('/post/{id}',            [HomeController::class, 'post']);
    Route::post('/post/{id}/comments',  [CommentController::class, 'store'])->name('comments.store');
    Route::get('/search',               [HomeController::class, 'search'])->name('search');
});

// Route cho người dùng
Route::middleware(['checkActive'])->group(function () {
    Route::get('/',                         [HomeController::class, 'index']);
    Route::get('/cate/{id}',                [HomeController::class, 'cate']);
    Route::get('/posts/{id}',               [HomeController::class, 'post']);
    Route::post('/posts/{id}/comments',     [CommentController::class, 'store'])->name('comments.store');
    Route::get('/search',                   [HomeController::class, 'search'])->name('search');
    Route::get('/profile',                  [ProfileController::class, 'index'])->name('client.profile');
    Route::put('/profile/update/{user}',    [ProfileController::class, 'updateUser'])->name('profile.update');
    Route::get('profile/{post}/edit',       [ProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('/posts/{post}',             [ProfileController::class, 'updatePost'])->name('posts.update');
});

// Route cho admin
Route::middleware(['checkLevel'])->prefix('admin')->group(function () {
    Route::resource('dashboard',  DashboardController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags',       TagController::class);
    Route::resource('posts',      PostController::class);
    Route::resource('users',      UserController::class);

    Route::get('comments',                  [CommentController::class, 'index'])->name('comments.index');
    Route::get('comments/{comment}',        [CommentController::class, 'show'])->name('comments.show');
    Route::get('comments/{comment}/edit',   [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('comments/{comment}',        [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}',     [CommentController::class, 'destroy'])->name('comments.destroy');
});

Auth::routes();
