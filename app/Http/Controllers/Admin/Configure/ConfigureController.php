<?php

namespace App\Http\Controllers\Admin\Configure;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configure;
use App\Repositories\ConfigureRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Configure\CreateRequest;
use App\Http\Requests\Admin\Configure\UpdateRequest;
use Exception;


class ConfigureController extends Controller
{
    /** @var App\Repositories\{configure}RepositoryInterface configureRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $configureRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{configure}RepositoryInterface $configureRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        ConfigureRepositoryInterface $configureRepository,
        FileServices $fileServices,
    ) {
        $this->configureRepository = $configureRepository;
        $this->fileServices   = $fileServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->hasPermissionTo('list configure')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'configure', 'url' => route('configure.index')],
                ['title' => 'configure', 'url' => route('configure.create')],
            ];

            $configures_page = $this->configureRepository->list_group();
//            dd($configures_page);
            $configures = [];
            foreach ($configures_page as $item){
                if($item){
                    $configures_list = $this->configureRepository->list($item->group_ordering);
                    $configures_groupname[$item['group_ordering']] = $this->configureRepository->first_groupname($item->group_ordering);
                    $configures[$item['group_ordering']] = $configures_list;
                }
            }
            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }

            return view('admin.configures.edit', compact('configures','configures_groupname','configures_page' , 'breadcrumbs'));
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

        if(env('APP_ENV') == 'local') {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'configure', 'url' => route('configure.index')],
                ['title' => 'configure', 'url' => route('configure.create')],
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
            $inputText = view('admin.configures.input_text');
            return view('admin.configures.create', compact('statusData', 'breadcrumbs','inputText'));
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
        if(\Auth::user()->hasPermissionTo('add configure')) {
            $input = $request->except(['_token']);
            if(empty($input)) {
                return Redirect::back()->with('error', 'Not Found!');
            }
            $configures = Configure::orderBy('configure_ordering', 'ASC')->where('configure_publish' , 1)->get();
            try {
                foreach ($configures as $key => $configure) {
                    if (isset($input[$configure->configure_name])) {
                        $configure->configure_value = $input[$configure->configure_name];
                        $configure->save();
                    }
                }
                return back()->with('success', 'Tạo bài viết thành công!');
            } catch(\Exception $e) {
                throw New \Exception($e);
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
        // $user = $this->configureRepository->findOrFail($id);
        // return view('admin.configure.show', compact('configure'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {

     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $input = $request->except(['_token']);
        $input['configure_publish'] = 1;
        try {
            $model = $this->configureRepository->create($input);
            return back()->with('success', 'Tạo thành công!');
        } catch (Exception $e) {
            var_dump($e->getMessage());
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

    }
}

