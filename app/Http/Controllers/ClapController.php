<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Clap;
use Illuminate\Http\Request;

class ClapController extends Controller
{
   public function clap($id, Request $request)
{
    $post = \App\Models\Post::findOrFail($id);

    $existing = \App\Models\Clap::where('post_id', $post->id)
        ->where('user_id', $request->user()->id)
        ->first();

    if ($existing) {
        // If already clapped, remove
        $existing->delete();
        $hasClapped = false;
    } else {
        // Else, add new clap
        \App\Models\Clap::create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);
        $hasClapped = true;
    }

    return response()->json([
        'hasClapped' => $hasClapped,
        'clapsCount' => $post->claps()->count(),
    ]);
}

}