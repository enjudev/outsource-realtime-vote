<?php

namespace App\Http\Controllers\Admin\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Repositories\MenuRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Menu\CreateRequest;
use App\Http\Requests\Admin\Menu\UpdateRequest;
use Exception;
use Str;

class MenuController extends Controller
{
    /** @var App\Repositories\{menu}RepositoryInterface menuRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $menuRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{menu}RepositoryInterface $menuRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        MenuRepositoryInterface $menuRepository,
        FileServices $fileServices,
    ) {
        $this->menuRepository = $menuRepository;
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
        if(\Auth::user()->hasPermissionTo('list menu')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $menus = $this->menuRepository->all();
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'menu', 'url' => route('menu.index')]
            ];
            $menu = builderCategoryTree($menus);
            return view('admin.menus.index', compact('menus' , 'breadcrumbs','menu'));
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
        if(\Auth::user()->hasPermissionTo('add menu')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'menu', 'url' => route('menu.index')],
                ['title' => 'menu', 'url' => route('menu.create')],
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
            $menus = $this->menuRepository->all();
            return view('admin.menus.edit', compact('statusData', 'breadcrumbs','menus'));
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
        if(\Auth::user()->hasPermissionTo('add menu')) {
            $input = $request->except(['_token']);
            try {
                $model = $this->menuRepository->create($input);
                return redirect(route('menu.index'))->with('success', 'Tạo bài viết thành công!');
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
        // $user = $this->menuRepository->findOrFail($id);
        // return view('admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        if(\Auth::user()->hasPermissionTo('edit menu')) {
            $menu = $this->menuRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'menu', 'url' => route('menu.index')],
                ['title' => 'menu', 'url' => route('menu.edit' , ['menu' => $id])],
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
            $menus = $this->menuRepository->all();
            return view('admin.menus.edit', compact('statusData', 'menu',  'breadcrumbs','menus'));
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
        if(\Auth::user()->hasPermissionTo('edit menu')) {
            $input = $request->except(['_token']);
            $model = $this->menuRepository->findOrFail($id);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->menuRepository->update($model, $input);
                    return redirect()->route('menu.index')->with('success', 'Update successfully');
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
        if(\Auth::user()->hasPermissionTo('delete menu')) {
            $menu = $this->menuRepository->findOrFail($id);
            if (empty($menu)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->menuRepository->delete($menu);

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

