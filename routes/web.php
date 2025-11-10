<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ClapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowerController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/category/{category}', [PostController::class, 'category'])->name('posts.byCategory');
Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('dashboard');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/create', [PostController::class, 'store'])->name('posts.store');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('posts/{post:slug}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::get('my-posts', [PostController::class, 'myPosts'])->name('myPosts');
    Route::post('/follow/{user}', [FollowerController::class, 'follow'])->name('follow.toggle');
});
Route::middleware('auth')->group(function () {
    Route::post('/clap/{id}', [ClapController::class, 'clap'])->name('clap.store');
    Route::get('/posts/{id}/clap-count', [ClapController::class, 'count'])->name('posts.clap.count');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';

// 👇 move this route to the very end
Route::get('/{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');
