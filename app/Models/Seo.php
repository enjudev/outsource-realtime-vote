<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'seo_image',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'seo_canonical'
    ];
}
