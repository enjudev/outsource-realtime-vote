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
$route = empty($post) ? 'post.store' : ['post.update', $post->id];
$method = empty($post) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'post' => 'form'])
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
                        <input type="text" name="title" value="{{isset($post) ? $post->title : ''}}" class="form-control" id="title" placeholder="Title">
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="summary">Summary</label>
                        <input type="text" name="summary" value="{{isset($post) ? $post->summary : ''}}" class="form-control" id="summary" placeholder="summary">
                        @error('summary')
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
                            @foreach($categoryTree as $category)
                            <option class="text-black font-medium" value="{{ $category->id }}" {{ $category->id == (isset($post->parent_id) ? $post->parent_id : '') ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="published">Published</label>
                        <select class="select2 form-control" style="width: 100%;" name="published">
                            @foreach($statusData as $data)
                            @if(isset($post))
                            <option class="text-black font-medium" value="{{$data['value']}}" {{$post->published ==
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
                            @if(isset($post))
                            <option class="text-black font-medium" value="{{$data}}" {{$post->label ==
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
                        <label for="slug">URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">{{ $_SERVER['HTTP_HOST'] }}/</span>
                            <input type="text" class="form-control" name="slug" placeholder="url" value="{{isset($post->slug) ? $post->slug : old('slug')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Color link post picker:</label>
                        <input type="text" class="form-control colorpicker1 colorpicker-element" data-colorpicker-id="1" data-original-title="" title="" name="linkColor"  value="{{isset($post->linkColor) ? $post->linkColor : old('linkColor')}}">
                    </div>
                    <div class="form-group">
                        <label for="Description">Description</label>
                        <textarea name="description" id="ckeditor" rows="10" cols="80">
                            {!! isset($post->description) ? $post->description : '' !!}
                        </textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
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
                        @if(isset($post) == true)
                        <img src="{{asset($post->thumbnail)}}" style="width:100%" class="img-fluid" alt="" />
                        @else
                        <img src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid" alt=".." />
                        @endif
                        <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                            Upload
                        </button>
                        <input type="hidden" name="thumbnail" value="{{isset($post->thumbnail) ? $post->thumbnail : ''}}" />
                        @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Seo</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">

                        <label for="seo_title">seo_title</label>
                        <input type="text" name="seo_title" value="{{isset($post) ? $post->seo_title : ''}}" class="form-control" id="seo_title" placeholder="seo_title">
                        @error('seo_title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group">

                        <label for="seo_description">seo_description</label>
                        <input type="text" name="seo_description" value="{{isset($post) ? $post->seo_description : ''}}" class="form-control" id="seo_description" placeholder="seo_description">
                        @error('seo_description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group">

                        <label for="seo_keyword">seo_keyword</label>
                        <input type="text" name="seo_keyword" value="{{isset($post) ? $post->seo_keyword : ''}}" class="form-control" id="seo_keyword" placeholder="seo_keyword">
                        @error('seo_keyword')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="seo_canonical">seo_canonical</label>
                        <input type="text" name="seo_canonical" value="{{isset($post) ? $post->seo_canonical : ''}}" class="form-control" id="seo_canonical" placeholder="seo_canonical">
                        @error('seo_canonical')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label class="meta_robot">Set index - follow :</label>
                        <select class="select2 form-control" style="width: 100%;" name="meta_robot">
                            <option class="text-black font-medium" value="Index,Follow" @if(isset($post->meta_robot) && $post->meta_robot == 'Index,Follow') checked @endif>Index,Follow</option>
                            <option class="text-black font-medium" value="noIndex,nofollow" @if(isset($post->meta_robot) && $post->meta_robot == 'noIndex,nofollow') checked @endif>noIndex,nofollow</option>
                            <option class="text-black font-medium" value="Index,nofollow" @if(isset($post->meta_robot) && $post->meta_robot == 'Index,nofollow') checked @endif>Index,nofollow</option>
                            <option class="text-black font-medium" value="noIndex,Follow" @if(isset($post->meta_robot) && $post->meta_robot == 'noIndex,Follow') checked @endif>noIndex,Follow</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="">Enable comment</label>
                        <div class="input-form">
                            <input type="checkbox" class="switchenableComment" data-toggle="toggle" data-onstyle="success"  @if(isset($post->enableComment) && $post->enableComment == 'on') checked @endif>
                            <input type="hidden" name="enableComment" value="">
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="">First display</label>
                        <div class="input-form">
                            <input type="checkbox" class="switchdisplayPriority" @if(isset($post->displayPriority) && $post->displayPriority == 'on') checked @endif data-toggle="toggle" data-onstyle="success">
                            <input type="hidden" name="displayPriority" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="box-title">Schema ( <span style="color:red;">định dạng json</span> )</label>
                        <textarea type="json" name="schema" rows="8" cols="80" class="form-control" id="seo_schema" placeholder="schema json">{{ isset($post) ? $post->schema : old('schema') }}</textarea>
                    </div>
                    @error('schema')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>
        {!! Form::close() !!}
</section>
@endsection()

@section('script')
{!! \Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') !!}
<script type="text/javascript">
    $('.btn-reset-form').on('click', '', function() {
        //$('.form-horizontal').trigger("reset");
        $('.form-horizontal').on('form-horizontal', function() {
            $(this).find('form')[0].reset();
        });
    });
    $(document).on('input', 'input[name=slug]', function() {
        var slug = $(this).val();
        slug = slug.toLowerCase()
                            .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                            .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                            .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                            .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                            .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                            .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                            .replace(/đ/gi, 'd').replace(/[^a-z0-9]+/g, '-').trim();
        $(this).val(slug);
    });
    $('.switchenableComment').on('change', function() {
        if ($(this).prop('checked')) {
            $('input[name=enableComment]').val('on');
        } else {
            $('input[name=enableComment]').val('off');
        }
    });

    $('.switchdisplayPriority').on('change', function() {
        if ($(this).prop('checked')) {
            $('input[name=displayPriority]').val('on');
        } else {
            $('input[name=displayPriority]').val('off');
        }
    });
</script>
<script>
    $('.colorpicker1').colorpicker()
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(document).on('click', '.ckfinderUploadImage', function() {
        $currentElement = $(this);
        CKFinder.modal({
            language: "vi",
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function(finder) {
                finder.on("files:choose", function(evt) {
                    var file = evt.data.files.first();
                    var thumbnail = file.getUrl();
                    $currentElement.prev().attr("src", `{{ asset('${thumbnail.substring(1)}')  }}`);
                    $currentElement.next().val(thumbnail);
                });
            },
        });
    })
</script>
@endsection