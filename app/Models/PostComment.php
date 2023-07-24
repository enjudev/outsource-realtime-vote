<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'author',
        'timeAgo',
        'published',
        'content',
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_post_comments', 'comment_id', 'post_id');
    }
}
