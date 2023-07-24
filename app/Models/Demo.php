<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'thumbnail',
        'summary',
        'view',
        'description',
        'status',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'seo_canonical',
    ];
}
