<?php

namespace App\Http\Controllers\Admin\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Demo;
use App\Repositories\DemoRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Demo\CreateRequest;
use App\Http\Requests\Admin\Demo\UpdateRequest;
use Exception;


class DemoController extends Controller
{
    /** @var App\Repositories\{demo}RepositoryInterface demoRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $demoRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{demo}RepositoryInterface $demoRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        DemoRepositoryInterface $demoRepository,
        FileServices $fileServices,
    ) {
        $this->demoRepository = $demoRepository;
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
        if(\Auth::user()->hasPermissionTo('list demo')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $demos     = $this->demoRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'demo', 'url' => route('demo.index')]
            ];
            return view('admin.demos.index', compact('demos' , 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add demo')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'demo', 'url' => route('demo.index')],
                ['title' => 'demo', 'url' => route('demo.create')],
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
            return view('admin.demos.edit', compact('statusData', 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add demo')) {
            $input = $request->except(['_token']);
            try {
                $model = $this->demoRepository->create($input);
                return redirect(route('demo.index'))->with('success', 'Tạo bài viết thành công!');
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
        // $user = $this->demoRepository->findOrFail($id);
        // return view('admin.demo.show', compact('demo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        if(\Auth::user()->hasPermissionTo('edit demo')) {
            $demo = $this->demoRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'demo', 'url' => route('demo.index')],
                ['title' => 'demo', 'url' => route('demo.edit' , ['demo' => $id])],
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
            return view('admin.demos.edit', compact('statusData', 'demo',  'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('edit demo')) {
            $input = $request->except(['_token']);
            $model = $this->demoRepository->findOrFail($id);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->demoRepository->update($model, $input);
                    return redirect()->route('demo.index')->with('success', 'Update successfully');
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
        if(\Auth::user()->hasPermissionTo('delete demo')) {
            $demo = $this->demoRepository->findOrFail($id);
            // if (empty($demo)) {
            //     session()->flash('error', 'Not found user.');

            //     return response([],500);
            // }
            try {
                $this->demoRepository->delete($demo);
                session()->flash('success', 'Destroy successfully.');
                return response(['message'=>'asdsd'],200);
            } catch (Exception $e) {
                throw new Exception($e);
            }
        } else {
            \App::abort(403);
        }
    }
}

