<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>  $this->id,
            "name" =>  $this->name,
            "role" =>  $this->role,
            "status" =>  $this->status,
            "group_id" =>  $this->group_id,
            "username" =>  $this->username,
            "avatar_url" => $this->avatar_path ? Storage::url($this->avatar_path) : '/images/default_pfp.png',
        ];
    }
}
