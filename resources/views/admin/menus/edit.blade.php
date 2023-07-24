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
$route = empty($menu) ? 'menu.store' : ['menu.update', $menu->id];
$method = empty($menu) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'menu' => 'form'])
!!}
<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Main</h3>
                </div>
                <div class="box-body">
                <div class="form-group">
                        <label for="name">Name menu {!! isRequired() !!}</label>
                        <input type="text" name="name" value="{{isset($menu) ? $menu->name : ''}}"
                            class="form-control" id="name" placeholder="name">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url">URL {!! isRequired() !!}</label>
                            <input type="text" class="form-control" name="url" placeholder="https://example.com" size="30"
                                required value="{{isset($menu->url) ? $menu->url : old('url')}}">
                        @error('url')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        @php
                        $categoryTree = builderCategoryTree($menus);
                        @endphp
                        <label class="status">Parent Id</label>
                        <select class="select2 form-control" style="width: 100%;" name="parent_id">
                            <option value="0">Menu chính</option>
                            @foreach($categoryTree as $category)
                            <option class="text-black font-medium" value="{{ $category->id }}" {{ $category->id == (isset($menu->parent_id) ? $menu->parent_id : '') ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="status">Status</label>
                        <select class="select2 form-control" style="width: 100%;" name="status">
                            @foreach($statusData as $data)
                            @if(isset($menu))
                            <option class="text-black font-medium" value="{{$data['value']}}" {{$menu->status ==
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
                        <label for="ordering">Ordering {!! isRequired() !!}</label>
                        <input type="text" name="ordering" value="{{isset($menu) ? $menu->ordering : ''}}"
                            class="form-control" id="ordering" placeholder="ordering">
                        @error('ordering')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div><!--End Row-->
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
</script>

<script>
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
@endsection
