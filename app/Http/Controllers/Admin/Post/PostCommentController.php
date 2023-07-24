<?php

namespace App\Http\Controllers\Admin\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PostComment;
use App\Repositories\PostCommentRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\PostComment\CreateRequest;
use App\Http\Requests\Admin\PostComment\UpdateRequest;
use App\Models\Post;
use Carbon\Carbon;
use Exception;


class PostCommentController extends Controller
{
    /** @var App\Repositories\{postcomment}RepositoryInterface postcommentRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $postcommentRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{postcomment}RepositoryInterface $postcommentRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        PostCommentRepositoryInterface $postcommentRepository,
        FileServices $fileServices,
    ) {
        $this->postcommentRepository = $postcommentRepository;
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
        if(\Auth::user()->hasPermissionTo('list postcomment')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');


            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $postcomments     = $this->postcommentRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'postcomment', 'url' => route('postcomment.index')]
            ];
            foreach ($postcomments as $key => $value) {
                $postCreatedAt = Carbon::parse($value->timeAgo);
                $now = Carbon::now();
                $value->timeAgo = $postCreatedAt->diffForHumans($now);
            }
            $countCommentNoActive = count(PostComment::where('published' , 0)->get());
            $countCommentActive = count(PostComment::where('published' , 1)->get());
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
            return view('admin.posts.postcomments.index', compact('postcomments' , 'breadcrumbs','statusData','countCommentNoActive','countCommentActive'));
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
        if(\Auth::user()->hasPermissionTo('add postcomment')) {
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'postcomment', 'url' => route('postcomment.index')],
                ['title' => 'postcomment', 'url' => route('postcomment.create')],
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
            $posts = Post::all();
            return view('admin.posts.postcomments.edit', compact('statusData', 'breadcrumbs','posts'));
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
        if(\Auth::user()->hasPermissionTo('add postcomment')) {
            $input = $request->except(['_token']);
            $input['timeAgo'] = Carbon::now();
            try {
                $model = $this->postcommentRepository->create($input);
                $model->posts()->attach($request->post_id);
                return redirect(route('postcomment.index'))->with('success', 'Tạo bài viết thành công!');
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
        // $user = $this->postcommentRepository->findOrFail($id);
        // return view('admin.postcomment.show', compact('postcomment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        // if(\Auth::user()->hasPermissionTo('edit postcomment')) {
        //     $postcomment = $this->postcommentRepository->findOrFail($id);
        //     $breadcrumbs = [
        //         ['title' => 'Home', 'url' => route('home.index')],
        //         ['title' => 'postcomment', 'url' => route('postcomment.index')],
        //         ['title' => 'postcomment', 'url' => route('postcomment.edit' , ['postcomment' => $id])],
        //     ];
        //     $statusData = [
        //         [
        //             'name' => 'Ẩn',
        //             'value' => 0,
        //         ],
        //         [
        //             'name' => 'Hiện',
        //             'value' => 1,
        //         ],
        //     ];
        //     return view('admin.posts.postcomments.edit', compact('statusData', 'postcomment',  'breadcrumbs'));
        // } else {
        //     \App::abort(403);
        // }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->hasPermissionTo('edit postcomment')) {
            $input = $request->except(['_token']);
            $model = $this->postcommentRepository->findOrFail($id);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->postcommentRepository->update($model, $input);
                    return redirect()->route('postcomment.index')->with('success', 'Update successfully');
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
        if(\Auth::user()->hasPermissionTo('delete postcomment')) {
            $postcomment = $this->postcommentRepository->findOrFail($id);
            if (empty($postcomment)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->postcommentRepository->delete($postcomment);

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

