<?php

namespace App\Http\Controllers\Admin\SiteMapGoogle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
class PostSitemapGoogleController extends Controller
{
    public function index()
    {
        $alphas = range('a', 'z');
        $posts = Post::orderBy('updated_at', 'desc')->paginate(100);
       
        return response()->view('admin.sitemap.posts.index', [
            'alphas' => $alphas,
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }
    public function show($letter){
        $posts = Post::where('slug', 'LIKE', "$letter%")->get();
        return response()->view('admin.sitemap.posts.show', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }
}
