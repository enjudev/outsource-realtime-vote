<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'Home', 'wheres' => 'App\Models\Home'], function () {
            Route::resource('/home', '\App\Http\Controllers\Admin\Home\HomeController');
        });
    });

    Route::group(['namespace' => 'Lang'], function () {
        Route::get('lang/{lang}', '\App\Http\Controllers\Admin\Lang\LangController@changeLang')->name('lang');
    });

    Route::group(['namespace' => 'User', 'wheres' => 'App\Models\User'], function () {
        Route::resource('/user', '\App\Http\Controllers\Admin\User\UserController');

        Route::get('/profile/{id}', '\App\Http\Controllers\Admin\User\UserController@profileUser')->Name('profile');

        Route::post('/set-permission', '\App\Http\Controllers\Admin\User\UserController@setPermission')->name('setPermission');
    });
    Route::group(['namespace' => 'RolePermission', 'wheres' => 'App\Models\User'], function () {
        Route::resource('/rolepermission', '\App\Http\Controllers\Admin\RolePermission\RolePermissionController');
    });
    Route::group(['namespace' => 'Log', 'wheres' => 'App\Models\Log'], function () {
        Route::resource('/log', '\App\Http\Controllers\Admin\Log\LogController');
    });
    Route::group(['namespace' => 'Post', 'wheres' => 'App\Models\Post'], function () {
        Route::resource('/post', '\App\Http\Controllers\Admin\Post\PostController');
    });
    Route::group(['namespace' => 'Post', 'wheres' => 'App\Models\CategoryPost'], function () {
        Route::resource('/categorypost', '\App\Http\Controllers\Admin\Post\CategoryPostController');
    });
    Route::group(['namespace' => 'Post', 'wheres' => 'App\Models\PostComment'], function () {
        Route::resource('/postcomment', '\App\Http\Controllers\Admin\Post\PostCommentController');
    });

    Route::group(['namespace' => 'Demo', 'wheres' => 'App\Models\Demo'], function () {
        Route::resource('/demo', '\App\Http\Controllers\Admin\Demo\DemoController');
    });
    Route::group(['namespace' => 'Configure', 'wheres' => 'App\Models\Configure'], function () {
        Route::resource('/configure', '\App\Http\Controllers\Admin\Configure\ConfigureController');
        Route::post('/configure/send', '\App\Http\Controllers\Admin\Configure\ConfigureController@send')->name('configure.send');
    });

    Route::group(['namespace' => 'LangCustom', 'wheres' => 'App\Models\LangCustom'], function () {
        Route::resource('/langcustom', '\App\Http\Controllers\Admin\LangCustom\LangCustomController');
    });
    Route::group(['namespace' => 'Contact', 'wheres' => 'App\Models\Contact'], function () {
        Route::resource('/contact', '\App\Http\Controllers\Admin\Contact\ContactController');
    });
    Route::group(['namespace' => 'Redirect', 'wheres' => 'App\Models\Redirect'], function () {
        Route::resource('redirect', '\App\Http\Controllers\Admin\Redirect\RedirectController');
        Route::post('/remove-redirect', '\App\Http\Controllers\Admin\Redirect\RedirectController@removeAll')->name('redirect.removeAll');
        Route::post('update-redirect', '\App\Http\Controllers\Admin\Redirect\RedirectController@upgrate')->name('upgrate');
    });
    Route::group(['namespace' => 'Seo', 'wheres' => 'App\Models\Seo'], function () {
        Route::resource('/seo', '\App\Http\Controllers\Admin\Seo\SeoController');
    });
    Route::group(['namespace' => 'Menu', 'wheres' => 'App\Models\Menu'], function () {
        Route::resource('/menu', '\App\Http\Controllers\Admin\Menu\MenuController');
    });
    Route::group(['namespace' => 'Room', 'wheres' => 'App\Models\Room'], function () {
        Route::resource('/room', '\App\Http\Controllers\Admin\Room\RoomController');
        Route::post('/room/add-option', '\App\Http\Controllers\Admin\Room\RoomController@addOption')->name('room.addOption');
        Route::post('/room/remove-option', '\App\Http\Controllers\Admin\Room\RoomController@removeOption')->name('room.removeOption');
    });
});


Route::group(['namespace' => 'Admin', 'wheres' => 'App\Model\User'],  function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/admin/login', '\App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('login.get');
        Route::post('/admin/login', '\App\Http\Controllers\Admin\Auth\LoginController@authenticate')->name('login.post');
        Route::post('/admin/logout', '\App\Http\Controllers\Admin\Auth\LoginController@logout')->name('logout.post');
    });
});


Route::get('/room/{uuid}', '\App\Http\Controllers\Frontend\HomeController@index')->name('room.view');
Route::post('/room/submit-vote', '\App\Http\Controllers\Frontend\HomeController@submitVote')->name('room.submitVote');
Route::get('/error', function () {
    return view('admin.errors.404');
})->name('404.error');
Route::get('kien-thuc-{slug}', '\App\Http\Controllers\Admin\Seo\SeoController@sitemapTest')->name('test.sitemap');
Route::get('/sitemapNew.xml', 'App\Http\Controllers\Admin\SiteMapGoogle\SitemapGoogleController@index')->name('sitemap.index');
Route::get('/sitemap/posts.xml', 'App\Http\Controllers\Admin\SiteMapGoogle\PostSitemapGoogleController@index')->name('sitemap.posts.index');
Route::get('/sitemap/posts/{letter}.xml', 'App\Http\Controllers\Admin\SiteMapGoogle\PostSitemapGoogleController@show')->name('sitemap.posts.show');

Route::get('/{any}', 'App\Http\Controllers\Admin\Redirect\RedirectController@redirect')->where('any', '.*');
