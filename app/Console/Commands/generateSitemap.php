<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use App\Models\PostCategory;
use App\Models\Post;

class generateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate sitemap daily everyMinute';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $posts = Post::all();
        $sitemap = Sitemap::create();
        foreach ($posts as $post) {
            $sitemap->add(route('test.sitemap', ['slug' => $post->slug]), $post->created_at, '0.6', 'daily');
        }
        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('create sitemap successfully!');
    }
}
