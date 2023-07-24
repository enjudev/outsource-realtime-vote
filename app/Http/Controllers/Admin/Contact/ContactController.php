<?php

namespace App\Http\Controllers\Admin\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repositories\ContactRepositoryInterface;
use App\Services\Production\FileServices;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\Contact\CreateRequest;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use Exception;


class ContactController extends Controller
{
    /** @var App\Repositories\{contact}RepositoryInterface contactRepository */
    /** @var App\Services\Production\FileServices FileServices */
    protected $contactRepository;
    protected $fileServices;
    protected $provinceRepository;
    protected $districtRepository;

    /**
     * class UserController.
     *
     * @param \{contact}RepositoryInterface $contactRepository
     * @param FileServices $fileServices
     */
    public function __construct(
        ContactRepositoryInterface $contactRepository,
        FileServices $fileServices,
    ) {
        $this->contactRepository = $contactRepository;
        $this->fileServices   = $fileServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        if(\Auth::user()->hasPermissionTo('list contact')) {
            $offset    = $request->get('offset', '');
            $limit     = $request->get('limit', 20);
            $order     = $request->get('order', 'id');
            $direction = $request->get('direction','DESC');

            $queryWord = $request->get('query');
            $statusData = [
                [
                    'name' => 'Chưa xem',
                    'value' => 0,
                ],
                [
                    'name' => 'Đã xem',
                    'value' => 1,
                ],
            ];

            $filter = [];
            if (!empty($queryWord)) {
                $filter['query'] = $queryWord;
            }
            $contacts     = $this->contactRepository->allByFilterPagination($filter, $limit, $order, $direction);
            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home.index')],
                ['title' => 'Registration form', 'url' => route('contact.index')]
            ];
            return view('admin.contacts.index', compact('contacts' , 'breadcrumbs','statusData'));
//        } else {
//            \App::abort(403);
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
            $input = $request->except(['_token']);
            try {
                $model = $this->contactRepository->create($input);
                return response()->json(['status' => 'success', 'message' => 'Chúc mừng bạn đăng ký thành công']);
            } catch(\Exception $e) {
                throw New \Exception($e);
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
        // $user = $this->contactRepository->findOrFail($id);
        // return view('admin.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
//        if(\Auth::user()->hasPermissionTo('edit contact')) {
            $contact = $this->contactRepository->findOrFail($id);

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home-admin.index')],
                ['title' => 'Registration form', 'url' => route('contact.index')],
                ['title' => 'Registration form', 'url' => route('contact.edit' , ['contact' => $id])],
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
            return view('admin.contacts.edit', compact('statusData', 'contact',  'breadcrumbs'));
//        } else {
//            \App::abort(403);
//        }
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
//        if(\Auth::user()->hasPermissionTo('edit contact')) {
            $model = $this->contactRepository->findOrFail($id);
            $input = $request->except(['_token']);
            if(empty($model)) {
                return Redirect::back()->with('error', 'Not Found!');
            } else {
                try {
                $this->contactRepository->update($model, $input);
                    return redirect()->route('contact.index')->with('success', 'Update successfully');
                } catch(\Exception $e) {
                    throw new Exception($e);
                }
            }
//        } else {
//            \App::abort(403);
//        }
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
//        if(\Auth::user()->hasPermissionTo('delete contact')) {
            $contact = $this->contactRepository->findOrFail($id);
            if (empty($contact)) {
                session()->flash('error', 'Not found user.');

                return ['error' => true];
            }
            try {
                $this->contactRepository->delete($contact);

                session()->flash('success', 'Destroy successfully.');

                return ['error' => false];
            } catch (\Exception $e) {
                throw new \Exception($e);
            }
//        } else {
//            \App::abort(403);
//        }
    }
}

