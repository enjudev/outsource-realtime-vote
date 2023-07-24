<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table = 'categories_posts';
    protected $fillable = [
        'name',
        'title',
        'thumbnail',
        'parent_id',
        'published',
        'slug',
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_tags','tag_id','post_id');
    }
}
