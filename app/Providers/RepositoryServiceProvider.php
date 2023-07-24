<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // repo User
        $this->app->singleton(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );
        //Eloquent
        $this->app->singleton(
            \App\Repositories\MenuRepositoryInterface::class,
            \App\Repositories\Eloquent\MenuRepository::class
        );
        $this->app->singleton(
            \App\Repositories\SeoRepositoryInterface::class,
            \App\Repositories\Eloquent\SeoRepository::class
        );
        $this->app->singleton(
            \App\Repositories\LangCustomRepositoryInterface::class,
            \App\Repositories\Eloquent\LangCustomRepository::class
        );
        $this->app->singleton(
            \App\Repositories\ContactRepositoryInterface::class,
            \App\Repositories\Eloquent\ContactRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\DemoRepositoryInterface::class,
            \App\Repositories\Eloquent\DemoRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PostRepositoryInterface::class,
            \App\Repositories\Eloquent\PostRepository::class
        );
        $this->app->singleton(
            \App\Repositories\ConfigureRepositoryInterface::class,
            \App\Repositories\Eloquent\ConfigureRepository::class
        );
        $this->app->singleton(
            \App\Repositories\LogRepositoryInterface::class,
            \App\Repositories\Eloquent\LogRepository::class
        );
        $this->app->singleton(
            \App\Repositories\CategoryPostRepositoryInterface::class,
            \App\Repositories\Eloquent\CategoryPostRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PostCommentRepositoryInterface::class,
            \App\Repositories\Eloquent\PostCommentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\RedirectRepositoryInterface::class,
            \App\Repositories\Eloquent\RedirectRepository::class
        );
    }
}
