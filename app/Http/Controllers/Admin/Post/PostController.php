<?php

namespace App\Http\Controllers\Admin\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Post\CreateRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use Exception;
use App\Repositories\CategoryPostRepositoryInterface;


class PostController extends Controller
{
    /** @var App\Repositories\{post}RepositoryInterface postRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $postRepository;
    protected $fileServices;
    protected $categoryPost;
    /**
     * class UserController.
     *
     * @param \{post}RepositoryInterface $postRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        FileServices $fileServices,
        CategoryPostRepositoryInterface $categoryPost
    ) {
        $this->postRepository = $postRepository;
        $this->fileServices   = $fileServices;
        $this->categoryPost = $categoryPost;
        $this->middleware('log');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list post')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $posts     = $this->postRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post', 'url' => route('post.index')]
            ];
            return view('admin.posts.index', compact('posts' , 'breadcrumbs'));
        } else {
            \App::abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->hasPermissionTo('add post')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post', 'url' => route('post.index')],
                ['title' => 'post', 'url' => route('post.create')],
            ];
            $statusData = [
                [
                    'name' => 'Hiện',
                    'value' => 1,
                ],
                [
                    'name' => 'Ẩn',
                    'value' => 0,
                ]
            ];
            $allCategory = $this->categoryPost->all();
            return view('admin.posts.edit', compact('statusData', 'breadcrumbs','allCategory'));
        } else {
            \App::abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('add post')) {
            $input = $request->except(['_token']);

            try {
                $model = $this->postRepository->create($input);
                $model->categories()->attach($model->parent_id);
                return redirect(route('post.index'))->with('success', 'Tạo bài viết thành công!');
            } catch(Exception $e) {
                throw New Exception($e);
            }
        } else {
            \App::abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = $this->postRepository->findOrFail($id);
        // return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        if(\Auth::user()->hasPermissionTo('edit post')) {
            $post = $this->postRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'post', 'url' => route('post.index')],
                ['title' => 'post', 'url' => route('post.edit' , ['post' => $id])],
            ];
            $statusData = [
                [
                    'name' => 'Ẩn',
                    'value' => 0,
                ],
                [
                    'name' => 'Hiện',
                    'value' => 1,
                ],
            ];
            $allCategory = $this->categoryPost->all();
            return view('admin.posts.edit', compact('statusData', 'post',  'breadcrumbs','allCategory'));
        } else {
            \App::abort(403);
        }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if(\Auth::user()->hasPermissionTo('edit post')) {
            $input = $request->except(['_token']);
            $model = $this->postRepository->findOrFail($id);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->postRepository->update($model, $input);
                $model->categories()->sync($input['parent_id']);
                    return redirect()->route('post.index')->with('success', 'Update successfully');
                } catch(\Exception $e) {
                    throw new Exception($e);
                }
            }
        } else {
            \App::abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy($id)
    {
        if(\Auth::user()->hasPermissionTo('delete post')) {
            $post = $this->postRepository->findOrFail($id);
            if (empty($post)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->postRepository->delete($post);

                session()->flash('success', 'Destroy successfully.');

                return ['error' => false];
            } catch (Exception $e) {
                throw new Exception($e);
            }
        } else {
            \App::abort(403);
        }
    }
}

