<?php

namespace App\Http\Controllers;

use App\Http\Enums\GroupUserStatusEnum;
use App\Http\Resources\GroupResource;
use App\Http\Resources\PostResource;
use App\Models\Group;
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
            ->with([
                'comments' => function ($query) use ($userID) {
                    $query->withCount('reactions'); // SELECT * FROM comments WHERE post_id IN (1, 2, 3...)
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

        $groups = Group::query()
            ->select(['groups.*', 'gu.status', 'gu.role'])
            ->join('group_users AS gu', 'gu.group_id', 'groups.id')
            ->where('gu.user_id', Auth::id())
            ->where('status', GroupUserStatusEnum::APPROVED->value)
            ->get();

        return Inertia::render("Home", [
            'posts' => $posts,
            'groups' => GroupResource::collection($groups),
        ]);
    }
}
