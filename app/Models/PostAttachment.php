<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostAttachment extends Model
{
    use HasFactory;

    CONST UPDATED_AT = null;

    protected $fillable = [
        'post_id',
        'name',
        'path',
        'mime',
        'size',
        'created_by',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
