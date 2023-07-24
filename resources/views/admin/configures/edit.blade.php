@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
{!! \Html::style('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
<style>
    .form-group {
        margin-left: 0px !important;
        margin-bottom: 25px!important;
        margin-right: 0px !important;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    .item_group{
         border: 1px solid #dddddd;
        margin-bottom: 20px;
        /*padding: 30px 20px;*/
    }
    .ckfinderUploadImage{
        width: 200px;
    }
    h4{
        text-align: center;
        margin-bottom: 20px;
        font-size: 32px;
        color: #00a65a;
        font-weight: bold;
    }
    .img-fluid{
        width: 200px!important;
        display: block;
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
$route = empty($configure) ? 'configure.store' : ['configure.update', $configure->id];
$method = empty($configure) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'configure' => 'form'])
!!}
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Configure</h3>
                </div>
                    @foreach($configures_page as $item)
                        <div class="box-body item_group">
                            <h4>{{$configures_groupname[$item['group_ordering']]->group_name}}</h4>
                                @foreach($configures[$item['group_ordering']] as $key => $configure)
                                    @switch($configure->configure_type)
                                        @case('text')
                                            <div class="form-group col-md-12">
                                                <label for="{{ $configure->configure_name }}">{{ $configure->configure_title }}</label>
                                                <input type="text" name="{{ $configure->configure_name }}" value="{{ isset($configure->configure_value) ?$configure->configure_value : '' }}" class="form-control" id="{{ $configure->configure_name }}" placeholder="{{ $configure->configure_name }}">
                                                @error('{{ $configure->configure_name }}')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            @break
                                        @case('textarea')
                                            <div class="form-group col-md-12">
                                                <label for="{{ $configure->configure_name }}">{{ $configure->configure_title }}</label>
                                                <textarea name="{{ $configure->configure_name }}" class="ckeditor" rows="10" cols="80">
                                                                {!! isset($configure->configure_value) ? $configure->configure_value : '' !!}
                                                            </textarea>
                                                @error('{{ $configure->configure_name }}')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            @break
                                        @case('image')
                                            <div class="form-group col-md-12">
                                                <label for="{{ $configure->configure_name}}">{{ $configure->configure_title }}</label>
                                                @if ($configure->configure_value)
                                                    <img src="{{ asset($configure->configure_value) }}" style="width:100%" class="img-fluid" alt="" />
                                                @else
                                                    <img cl src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid" alt=".." />
                                                @endif
                                                <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                                                    Upload
                                                </button>
                                                <input type="hidden" name="{{ $configure->configure_name}}" value="{{ isset($configure->configure_value) ? $configure->configure_value : '' }}" />
                                                @error('{{ $configure->configure_name}}')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            @break
                                        @case('switch')
                                            <div class="form-group col-md-12">
                                                <label for="{{ $configure->configure_name }}">{{ $configure->configure_title }}</label>
                                                <div class="form-group"></div>
                                                <label class="switch">
                                                    <input type="checkbox" @if($configure->configure_value == 'on') checked @endif id="switch{{ $configure->id }}" onclick="check({{ $configure->id }})">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <input type="hidden" id="val_switch{{ $configure->id }}" name="{{ $configure->configure_name }}" @if($configure->configure_value == 'on') value="on" @else value="off" @endif>
                                            <script>
                                                function check(id) {
                                                    if ($('#switch' + id).is(':checked')) {
                                                        $('#val_switch' + id).val('on')
                                                    } else {
                                                        $('#val_switch' + id).val('off')
                                                    }
                                                }
                                            </script>
                                            @break
                                        @case('date')
                                            <div class="form-group">
                                                <label>{{ $configure->configure_title }}</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                    <input type="text" name="{{ $configure->configure_name }}"  value="{{ isset($configure->configure_value) ? $configure->configure_value : '' }}"  class="form-control pull-right" id="reservationtime">
                                                </div>
                                            </div>
                                            @error('{{ $configure->configure_name}}')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            @break
                                        @default
                                    @endswitch
                                @endforeach
                        </div>
                    @endforeach
                <!-- /.box-body -->
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
{!! \Html::script('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}

<script type="text/javascript">
    $('.btn-reset-form').on('click', '', function() {
        //$('.form-horizontal').trigger("reset");
        $('.form-horizontal').on('form-horizontal', function() {
            $(this).find('form')[0].reset();
        });
    });
</script>

<script>
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(document).ready(function() {
        $("input[name='configure_bank_account']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    })
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
                    $currentElement.prev().attr("src", `{{ asset('${thumbnail.substring(1)}') }}`);
                    $currentElement.next().val(thumbnail);
                });
            },
        });
    })
</script>
@endsection
