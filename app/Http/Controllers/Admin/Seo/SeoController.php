<?php

namespace App\Http\Controllers\Admin\Seo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seo;
use App\Repositories\SeoRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Seo\CreateRequest;
use App\Http\Requests\Admin\Seo\UpdateRequest;
use Exception;


class SeoController extends Controller
{
    /** @var App\Repositories\{seo}RepositoryInterface seoRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $seoRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{seo}RepositoryInterface $seoRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        SeoRepositoryInterface $seoRepository,
        FileServices $fileServices,
    ) {
        $this->seoRepository = $seoRepository;
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
        if(\Auth::user()->hasPermissionTo('list seo')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $seos     = $this->seoRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'seo', 'url' => route('seo.index')]
            ];
            return view('admin.seos.index', compact('seos' , 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add seo')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'seo', 'url' => route('seo.index')],
                ['title' => 'seo', 'url' => route('seo.create')],
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
            return view('admin.seos.edit', compact('statusData', 'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('add seo')) {
            $input = $request->except(['_token']);

            try {
                $model = $this->seoRepository->create($input);
                return redirect(route('seo.index'))->with('success', 'Tạo bài viết thành công!');
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
        // $user = $this->seoRepository->findOrFail($id);
        // return view('admin.seo.show', compact('seo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        if(\Auth::user()->hasPermissionTo('edit seo')) {
            $seo = $this->seoRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'seo', 'url' => route('seo.index')],
                ['title' => 'seo', 'url' => route('seo.edit' , ['seo' => $id])],
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
            return view('admin.seos.edit', compact('statusData', 'seo',  'breadcrumbs'));
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
        if(\Auth::user()->hasPermissionTo('edit seo')) {
            $input = $request->except(['_token']);
            $model = $this->seoRepository->findOrFail($id);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->seoRepository->update($model, $input);
                    return redirect()->route('seo.index')->with('success', 'Update successfully');
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
        if(\Auth::user()->hasPermissionTo('delete seo')) {
            $seo = $this->seoRepository->findOrFail($id);
            if (empty($seo)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->seoRepository->delete($seo);

                session()->flash('success', 'Destroy successfully.');

                return ['error' => false];
            } catch (Exception $e) {
                throw new Exception($e);
            }
        } else {
            \App::abort(403);
        }
    }
    public function sitemapTest($slug) 
    {
        return true;
    }
}

