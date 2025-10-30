<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
   public function follow(Request $request, User $user)
    {
        // Toggle (attach/detach) the follow relationship
        $user->followers()->toggle($request->user()->id);

        return response()->json([
            'followersCount' => $user->followers()->count(), // ✅ Correct key name
        ]);
    }               
}
