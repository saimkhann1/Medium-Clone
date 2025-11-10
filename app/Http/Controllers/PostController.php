<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    $user = Auth::user();
    $query = Post::latest();

    if ($user) {
        $ids = $user->following->pluck('id');
        if ($ids->isNotEmpty()) {
            $query->whereIn('user_id', $ids)
                  ->where('published_at', '<', now());
        }
    }

    $categories = Category::all();
    $posts = $query->paginate(5);

    return view('posts.index', compact('categories', 'posts', 'user'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();
        // Handle image
        // $image = $data['image'];
        // unset($data['image']);

        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title']);

        // Store image in storage/app/public/posts
        // $imagePath = $image->store('posts', 'public');
        // $data['image'] = $imagePath;

        // Save post
        $post = Post::create($data);
        $post->addMediaFromRequest('image')->toMediaCollection();

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($username, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this post.');
        }
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to update this post.');
        }
        $data = $request->validated();
        $post->update($data);
        if($data['image'] ?? false){
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')->toMediaCollection();
        }
        return redirect()->route('myPosts')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this post.');
        }
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
    public function category(Category $category)
{
    $user = Auth::user();
    $categories = Category::all();

    $query = Post::where('category_id', $category->id)
                 ->where('published_at', '<', now())
                 ->latest();

    if ($user) {
        $ids = $user->following->pluck('users.id');
        if ($ids->isNotEmpty()) {
            $query->whereIn('user_id', $ids);
        }
    }

    $posts = $query->paginate(5);

    return view('posts.index', compact('categories', 'posts', 'category'));
}
    public function myPosts()
    {
        $user = Auth::user();
        $posts=$user->posts()->latest()->paginate(5);
        $categories = Category::all();
        return view('posts.index', compact('categories', 'posts', 'user'));
    }
}
