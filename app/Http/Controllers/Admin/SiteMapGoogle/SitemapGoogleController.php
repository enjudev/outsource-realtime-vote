<?php

namespace App\Http\Controllers\Admin\SiteMapGoogle;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\Controller;

class SitemapGoogleController extends Controller
{
    public function index()
    {
        $post = Post::orderBy('updated_at', 'desc')->first();

        return response()->view('admin.sitemap.index', [
            'post' => $post,
        ])->header('Content-Type', 'text/xml');
    }
}
