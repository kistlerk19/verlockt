<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $userID = Auth::id();
        $posts = Post::query()
            ->withCount('reactions')
            ->withCount('comments')
            ->with([
                'comments',
                'reactions' => function ($query) use ($userID) {
                    $query->where('user_id', $userID);
                }])
            ->latest()
            ->paginate(20);

        return Inertia::render("Home", [
            'posts' => PostResource::collection($posts)
        ]);
    }
}
