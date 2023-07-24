@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
<style>
    .form-group {
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
</style>
@endsection

@section('breadcrumb')
<section class="content-header">
    @include('admin.partials.breadcrumbs')
</section>
@endsection()

@section('content')
@php
$route = empty($categorypost) ? 'categorypost.store' : ['categorypost.update', $categorypost->id];
$method = empty($categorypost) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'categorypost' => 'form'])
!!}
<section class="content">
    <div class="row">
        <div class="col-md-9">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Main</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" value="{{isset($categorypost) ? $categorypost->title : ''}}"
                            class="form-control" id="title" placeholder="Title">
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{isset($categorypost) ? $categorypost->name : ''}}"
                            class="form-control" id="name" placeholder="name">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                    @php
                        function buildCategoryTree($categories, $parent_id = 0, $prefix = '') {
                            $categoryTree = [];

                            foreach ($categories as $category) {
                                if ($category->parent_id == $parent_id) {
                                    $category->name = $prefix . $category->name;
                                    $categoryTree[] = $category;
                                    $categoryTree = array_merge($categoryTree, buildCategoryTree($categories, $category->id, $prefix . '__'));
                                }
                            }
                            return $categoryTree;
                        }
                        $categoryTree = buildCategoryTree($allCategory);
                    @endphp
                        <label class="status">Parent Id</label>
                        <select class="select2 form-control" style="width: 100%;" name="parent_id">
                            <option class="text-black font-medium" value="0">
                                Chuyên mục cha
                            </option>
                            @foreach($categoryTree as $category)
                                <option class="text-black font-medium" value="{{ $category->id }}" {{ $category->id == (isset($categorypost->parent_id) ? $categorypost->parent_id : '') ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="status">Published</label>
                        <select class="select2 form-control" style="width: 100%;" name="published">
                            @foreach($statusData as $data)
                            @if(isset($categorypost))
                            <option class="text-black font-medium" value="{{$data['value']}}" {{$categorypost->published ==
                                $data['value'] ? 'selected' : ''}}>
                                {{$data['name']}}
                            </option>
                            @else
                            <option class="text-black font-medium" value="{{$data['value']}}">
                                {{$data['name']}}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Url (<span class="text-danger">Cấu trúc ex-ex-ex</span>)</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            {{ 'https://' . $_SERVER['HTTP_HOST'] }}
                            </div>
                            <input type="text" class="form-control" name="slug" placeholder="Đường dẫn url" value="{{ isset($categorypost->slug) ? $categorypost->slug : '' }}">
                        </div>

                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div><!--End Row-->
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Asset</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        @if(isset($categorypost) == true)
                        <img src="{{asset($categorypost->thumbnail)}}" style="width:100%" class="img-fluid" alt="" />
                        @else
                        <img src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid"
                            alt=".." />
                        @endif
                        <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                            Upload
                        </button>
                        <input type="hidden" name="thumbnail"
                            value="{{isset($categorypost->thumbnail) ? $categorypost->thumbnail : ''}}" />
                        @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
</section>
@endsection()

@section('script')
{!! \Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') !!}
<script type="text/javascript">
    $('.btn-reset-form').on('click', '', function () {
        //$('.form-horizontal').trigger("reset");
        $('.form-horizontal').on('form-horizontal', function () {
            $(this).find('form')[0].reset();
        });
    });
    $(document).on('input', 'input[name=slug]', function() {
        var slug = $(this).val();
        slug = slug.toLowerCase().replace(/[^a-z0-9]+/g, '-').trim();
        $(this).val(slug);
    });
</script>

<script>
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function () {
        $('.select2').select2();
    });
    $(document).on('click', '.ckfinderUploadImage', function () {
        $currentElement = $(this);
        CKFinder.modal({
            language: "vi",
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on("files:choose", function (evt) {
                    var file = evt.data.files.first();
                    var thumbnail = file.getUrl();
                    $currentElement.prev().attr("src", `{{ asset('${thumbnail.substring(1)}') }}`);
                    $currentElement.next().val(thumbnail);
                });
            },
        });
    })
</script>
@endsection
