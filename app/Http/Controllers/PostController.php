<?php

namespace App\Http\Controllers;

use App\Http\Enums\ImpressionEnum;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Impression;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, User $user)
    {
        $user = $request->user();
        $data = $request->validated();

        DB::beginTransaction();

        $filePaths = [];

        try {
            $post = Post::create($data);

            $files = $data['attachments'] ?? [];

            foreach ($files as $file) {
                $path = $file->store('images/' . $user->id . '/' . 'attachments/' . $post->id, 'public');
                $filePaths[] = $path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $user->id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            foreach ($filePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $user = $request->user();

        DB::beginTransaction();

        $filePaths = [];

        try {
            $data = $request->validated();
            $post->update($data);

            $deleted_ids = $data['deleted_file_ids'] ?? [];
            $attachments = PostAttachment::query()
                ->where('post_id', $post->id)
                ->whereIn('id', $deleted_ids)
                ->get();
            foreach ($attachments as $attachment) {
                $attachment->delete();
            }

            $files = $data['attachments'] ?? [];

            foreach ($files as $file) {
                $path = $file->store('images/' . $user->id . '/' . 'attachments/' . $post->id, 'public');
                $filePaths[] = $path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $user->id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            foreach ($filePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //

        $id = Auth::id();

        if ($post->user_id !== $id) {
            return response("You do not have permission to delete this post.", 403);
        }

        $post->delete();

        return back();
    }

    public function download(PostAttachment $attachment)
    {
        return response()->download(Storage::disk('public')->path($attachment->path), $attachment->name);
    }
    public function postReaction(Request $request, Post $post)
    {
        $userID = Auth::id();
        $data = $request->validate([
            'reaction' => [Rule::enum(ImpressionEnum::class)],
        ]);

        $reaction = Impression::where('user_id', $userID)
            ->where('object_id', $post->id)
            ->where('object_type', Post::class)
            ->first();

        if ($reaction) {
            $reaction->delete();
            $hasImpression = false;
        } else {
            Impression::create([
                'object_id' => $post->id,
                'object_type' => Post::class,
                'user_id' => $userID,
                'type' => $data['reaction'],
            ]);
            $hasImpression = true;
        }

        $reactions = Impression::where('object_id', $post->id)->where('object_type', Post::class)->count();

        return response([
            'impressions' => $reactions,
            'user_has_impression' => $hasImpression,
        ]);
    }

    public function createComment(Request $request, Post $post)
    {
        $userID = Auth::id();
        $data = $request->validate([
            'comment' => ['required'],
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'comment' => nl2br($data['comment']),
            'user_id' => $userID,
        ]);
        return response(new CommentResource($comment), 201);
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response("Yuou don't have permission to delete this comment!", 403);
        }

        $comment->delete();

        return response("", 204);
    }

    public function updateComment(UpdateCommentRequest $request, Comment $comment)
    {
        $data = $request->validated();

        $comment->update([
            'comment' => nl2br($data['comment']),
        ]);

        return new CommentResource($comment);
    }

    public function commentImpression(Request $request, Comment $comment)
    {
        $userID = Auth::id();
        $data = $request->validate([
            'reaction' => [Rule::enum(ImpressionEnum::class)],
        ]);

        $reaction = Impression::where('user_id', $userID)
            ->where('object_id', $comment->id)
            ->where('object_type', Comment::class)
            ->first();

        if ($reaction) {
            $reaction->delete();
            $hasImpression = false;
        } else {
            Impression::create([
                'object_id' => $comment->id,
                'object_type' => Comment::class,
                'user_id' => $userID,
                'type' => $data['reaction'],
            ]);
            $hasImpression = true;
        }

        $reactions = Impression::where('object_id', $comment->id)
            ->where('object_type', Comment::class)
            ->count();

        return response([
            'impressions' => $reactions,
            'user_has_impression' => $hasImpression,
        ]);
    }
}
