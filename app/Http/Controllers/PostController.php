<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PostAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

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

            foreach($files as $file)
            {
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
            foreach($attachments as $attachment) {
                $attachment->delete();
            }

            $files = $data['attachments'] ?? [];

            foreach($files as $file)
            {
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

        if($post->user_id !== $id)
        {
            return response("You do not have permission to delete this post.", 403);
        }

        $post->delete();

        return back();
    }
}
