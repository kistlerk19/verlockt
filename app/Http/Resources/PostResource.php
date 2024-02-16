<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $comments = $this->comments;
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->format('M-d-Y H:i:s'),
            'updated_at' => $this->updated_at->format('M-d-Y H:i:s'),
            'user' => new UserResource($this->user),
            'group' => $this->group,
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'impressions' => $this->reactions_count,
            'user_has_impression' => $this->reactions->count() > 0,
            'comments' => self::commentsToTree($comments),
            // 'comments' => CommentResource::collection($this->comments),
            'num_of_comments' => count($comments),
        ];
    }

    private static function commentsToTree($comments, $parentId = null): array
    {
        $commentTree = [];

        foreach ($comments as $comment) {
            if ($comment->parent_id === $parentId) {
                // Find all comments which has parentId as $comment->id
                $children = self::commentsToTree($comments, $comment->id);
                $comment->childComments = $children;
                $comment->numOfComments = collect($children)->sum('numOfComments') + count($children);
                $commentTree[] = new CommentResource($comment);
            }
        }

        return $commentTree;
    }
}
