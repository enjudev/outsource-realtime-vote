<?php

namespace App\Http\Controllers\Admin\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Repositories\CategoryPostRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\CategoryPost\CreateRequest;
use App\Http\Requests\Admin\CategoryPost\UpdateRequest;
use Exception;
use Illuminate\Support\Str;

class CategoryPostController extends Controller
{
    /** @var App\Repositories\{categorypost}RepositoryInterface categorypostRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $categorypostRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{categorypost}RepositoryInterface $categorypostRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        CategoryPostRepositoryInterface $categorypostRepository,
        FileServices $fileServices,
    ) {
        $this->categorypostRepository = $categorypostRepository;
        $this->fileServices   = $fileServices;
        $this->middleware('log');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list categorypost')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $categoryposts     = $this->categorypostRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'categorypost', 'url' => route('categorypost.index')]
            ];
            return view('admin.posts.categoryposts.index', compact('categoryposts' , 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add categorypost')) {
            $allCategory = $this->categorypostRepository->all();
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'categorypost', 'url' => route('categorypost.index')],
                ['title' => 'categorypost', 'url' => route('categorypost.create')],
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
           
            return view('admin.posts.categoryposts.edit', compact('statusData', 'breadcrumbs','allCategory'));
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
    public function store(CreateRequest $request)
    {
        if(\Auth::user()->hasPermissionTo('add categorypost')) {
            $input = $request->except(['_token']);
            try {
                $input['slug'] = Str::slug($input['slug']);
                $model = $this->categorypostRepository->create($input);
                return redirect(route('categorypost.index'))->with('success', 'Tạo bài viết thành công!');
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
        // $user = $this->categorypostRepository->findOrFail($id);
        // return view('admin.categorypost.show', compact('categorypost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        if(\Auth::user()->hasPermissionTo('edit categorypost')) {
            $categorypost = $this->categorypostRepository->findOrFail($id);
            $allCategory = $this->categorypostRepository->all();
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'categorypost', 'url' => route('categorypost.index')],
                ['title' => 'categorypost', 'url' => route('categorypost.edit' , ['categorypost' => $id])],
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
            return view('admin.posts.categoryposts.edit', compact('statusData', 'categorypost',  'breadcrumbs','allCategory'));
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
        if(\Auth::user()->hasPermissionTo('edit categorypost')) {
            $input = $request->except(['_token']);
            $input['slug'] = Str::slug($input['slug']);
            $model = $this->categorypostRepository->findOrFail($id);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->categorypostRepository->update($model, $input);
                    return redirect()->route('categorypost.index')->with('success', 'Update successfully');
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
        if(\Auth::user()->hasPermissionTo('delete categorypost')) {
            $categorypost = $this->categorypostRepository->findOrFail($id);
            if (empty($categorypost)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->categorypostRepository->delete($categorypost);

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

