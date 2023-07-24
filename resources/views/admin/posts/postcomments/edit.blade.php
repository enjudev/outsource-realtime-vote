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
$route = empty($postcomment) ? 'postcomment.store' : ['postcomment.update', $postcomment->id];
$method = empty($postcomment) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'postcomment' => 'form'])
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
                        <label for="author">Author</label>
                        <input type="text" name="author" value="{{isset($postcomment) ? $postcomment->author : ''}}"
                            class="form-control" id="author" placeholder="author">
                        @error('author')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="published">Published</label>
                        <select class="select2 form-control" style="width: 100%;" name="published">
                            @foreach($statusData as $data)
                            @if(isset($postcomment))
                            <option class="text-black font-medium" value="{{$data['value']}}" {{$postcomment->published ==
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
                        @error('published')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="post_id">post_id</label>
                        <select class="select2 form-control" style="width: 100%;" name="post_id">
                            @foreach($posts as $data)
                            <option class="text-black font-medium" value="{{$data->id}}">
                                {{$data->title}}
                            </option>
                            @endforeach
                        </select>
                        @error('published')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">content</label>
                        <textarea name="content" id="ckeditor" rows="10" cols="80">
                            {!! isset($postcomment->content) ? $postcomment->content : '' !!}
                        </textarea>
                        @error('content')
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
