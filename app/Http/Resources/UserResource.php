<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            "username" =>  $this->username,
            "email" =>  $this->email,
            "email_verified_at" =>  $this->email_verified_at,
            "created_at" =>  $this->created_at,
            "updated_at" =>  $this->created_at,
            "cover_url" =>  $this->cover_path ? Storage::url($this->cover_path) : '/images/default_cover.jpg',
            "avatar_url" => $this->avatar_path ? Storage::url($this->avatar_path) : '/images/default_pfp.png',
        ];
    }
}
