<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'comments' => function ($query) use ($userID) {
                    $query
                        ->whereNull('parent_id')
                        ->withCount('reactions')
                        ->withCount('comments')
                        ->with([
                            'reactions' => function ($query) use ($userID) {
                                $query->where('user_id', $userID);
                            }
                        ]);
                },
                'reactions' => function ($query) use ($userID) {
                    $query->where('user_id', $userID);
                }])
            ->latest()
            ->paginate(20);

        return Inertia::render("Home", [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
