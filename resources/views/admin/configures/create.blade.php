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

{!! Form::open(['route' => 'configure.send', 'method' => 'POST', 'class' => 'form-horizontal', 'configure' => 'form'])
!!}
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Main</h3>
                </div>
                <div class="box-body">
                    <ul id="sortable" class="list-group list-unstyled ui-sortable">
                        <li class="drag btn btn-primary" data-html="{!! base64_encode($inputText) !!}">change config type</li> =>      
                    </ul>
                      
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Main</h3>
                </div>
                <div class="box-body main_" style="min-height:400px;">
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        {!! Form::close() !!}
</section>
@endsection()

@section('script')
{!! \Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') !!}
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $('.drag').draggable({
        helper: "clone",
        connectToSortable: ".main_",
    })
    $( ".main_" ).sortable({
      revert: true,
      update: function (event, ui) {
            var attr = $(ui.item).attr('data-html');
            $('.main_').html(atob(attr));
        },
    });
</script>
@endsection
