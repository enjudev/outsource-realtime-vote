<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'summary',
        'parent_id',
        'published',
        'label',
        'slug',
        'linkColor',
        'enableComment',
        'displayPriority',
        'description',
        'thumbnail',
        'schema',
        'meta_robot',
        'seo_title',   
        'seo_description',
        'seo_keyword',
        'seo_canonical',
    ];
    public function categories()
    {
        return $this->belongsToMany(Post::class, 'posts_tags','post_id','tag_id');
    }
    public function comments()
    {
        return $this->belongsToMany(Post::class, 'post_post_comments', 'post_id' , 'comment_id');
    }
}
