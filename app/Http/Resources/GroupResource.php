<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'thumbnail_url' => $this->thumbnail_path ? Storage::url($this->thumbnail_path) : '/images/no_image.png',
            'cover_url' => $this->cover_path ? Storage::url($this->cover_path) : null,
            'auto_approval' => $this->auto_approval,
            'status' => $this->currentUserGroup?->status,
            'role' => $this->currentUserGroup?->role,
            'description' => Str::words($this->description, 10),
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
