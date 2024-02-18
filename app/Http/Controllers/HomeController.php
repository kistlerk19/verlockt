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
        $posts = Post::query() // SELECT  * FROM posts;
            ->withCount('reactions') // SELECT COUNT(*) FROM reactions
        // ->withCount('comments')
            ->with([
                'comments' => function ($query) use ($userID) {
                    $query
                    // ->whereNull('parent_id')
                        ->withCount('reactions') // SELECT * FROM comments WHERE post_id IN (1, 2, 3...)
                        // SELECT COUNT(*) FROM reactions
                        // ->withCount('comments')
                        // ->with([
                        //     'reactions' => function ($query) use ($userID) {
                        //         $query->where('user_id', $userID);
                        //     }
                        // ])
                    ;
                },
                'reactions' => function ($query) use ($userID) {
                    $query->where('user_id', $userID); // SELECT * FROM reactions WHERE user_id = ?
                }])
            ->latest()
            ->paginate(20);

        $posts = PostResource::collection($posts);
        if ($request->wantsJson()) {
            return $posts;
        }

        return Inertia::render("Home", [
            'posts' => $posts,
        ]);
    }
}
