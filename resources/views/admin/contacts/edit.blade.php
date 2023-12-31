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
$route = empty($contact) ? 'contact.store' : ['contact.update', $contact->id];
$method = empty($contact) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'contact' => 'form'])
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
                        <input type="text" name="title" value="{{isset($contact) ? $contact->title : ''}}"
                            class="form-control" id="title" placeholder="Title">
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" name="author" value="{{isset($contact) ? $contact->author : ''}}"
                            class="form-control" id="author" placeholder="author">
                        @error('author')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="summary">Summary</label>
                        <input type="text" name="summary" value="{{isset($contact) ? $contact->summary : ''}}"
                            class="form-control" id="summary" placeholder="summary">
                        @error('summary')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="status">Status</label>
                        <select class="select2 form-control" style="width: 100%;" name="status">
                            @foreach($statusData as $data)
                            @if(isset($contact))
                            <option class="text-black font-medium" value="{{$data['value']}}" {{$contact->status ==
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
                    @php
                    $labelData = ['hot', 'new'];
                    @endphp
                    <div class="form-group">
                        <label class="status">Label</label>
                        <select class="select2 form-control" style="width: 100%;" name="label">
                            @foreach($labelData as $data)
                            @if(isset($contact))
                            <option class="text-black font-medium" value="{{$data}}" {{$contact->label ==
                                $data ? 'selected' : ''}}>
                                {{$data}}
                            </option>
                            @else
                            <option class="text-black font-medium" value="{{$data}}">
                                {{$data}}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('label')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="summary">Description</label>
                        <textarea name="description" id="ckeditor" rows="10" cols="80">
                            {!! isset($contact->description) ? $contact->description : '' !!}
                        </textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Seo</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-md-6">

                        <label for="seo_title">seo_title</label>
                        <input type="text" name="seo_title" value="{{isset($contact) ? $contact->seo_title : ''}}"
                            class="form-control" id="seo_title" placeholder="seo_title">
                        @error('seo_title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_description">seo_description</label>
                        <input type="text" name="seo_description" value="{{isset($contact) ? $contact->seo_description : ''}}"
                            class="form-control" id="seo_description" placeholder="seo_description">
                        @error('seo_description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_keyword">seo_keyword</label>
                        <input type="text" name="seo_keyword" value="{{isset($contact) ? $contact->seo_keyword : ''}}"
                            class="form-control" id="seo_keyword" placeholder="seo_keyword">
                        @error('seo_keyword')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_canonical">seo_canonical</label>
                        <input type="text" name="seo_canonical" value="{{isset($contact) ? $contact->seo_canonical : ''}}"
                            class="form-control" id="seo_canonical" placeholder="seo_canonical">
                        @error('seo_canonical')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
                <!-- /.box-body -->
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
                        @if(isset($contact) == true)
                        <img src="{{asset($contact->thumbnail)}}" style="width:100%" class="img-fluid" alt="" />
                        @else
                        <img src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid"
                            alt=".." />
                        @endif
                        <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                            Upload
                        </button>
                        <input type="hidden" name="thumbnail"
                            value="{{isset($contact->thumbnail) ? $contact->thumbnail : ''}}" />
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
                    $currentElement.prev().attr("src", `{{ asset('${thumbnail.substring(1)}') }}' ) }}`);
                    $currentElement.next().val(thumbnail);
                });
            },
        });
    })
</script>
@endsection
