@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
{!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
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
{!! Form::open(['route' => 'langcustom.store', 'method' => 'POST', 'class' => 'form-horizontal', 'langcustom' => 'form'])
!!}
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Translate('home')}}</h3>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn change btn-primary">+ change</button>
                </div>
                <div class="box-body changeas">
                    <div class="wrap-content">
                        <div class="form-group col-md-4">
                            <label for="Key">Key</label>
                            <input type="text" name="lang[0][key]" value="" class="form-control" id="key" placeholder="key">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="en">En</label>
                            <input type="text" name="lang[0][en]" value="" class="form-control" id="en" placeholder="en">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="vi">Vi</label>
                            <input type="text" name="lang[0][vi]" value="" class="form-control" id="vi" placeholder="vi">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"> {{ translate('Submit') }}</button>
                </div>
            </div>
        </div><!--End Row-->
        {!! Form::close() !!}
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Danh sách dịch</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Key</th>
                                <th>En</th>
                                <th>Vi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i= 1; @endphp
                            @foreach ($langcustoms as $langcustom)
                            <tr>
                                <th scope="row" style="width:20px">{{$langcustom->id}}</th>
                                <td>{{$langcustom->key}}</td>
                                <td>{{$langcustom->en}}</td>
                                <td>{{$langcustom->vi}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#changeKey{{$langcustom->id}}"><i class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-url="{{ route('langcustom.destroy', $langcustom->id) }}" class="removeRecord" id="{{ $langcustom->id }}"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                            <div class="modal fade in" id="changeKey{{$langcustom->id}}" style="display: none; padding-right: 15px;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        {!! Form::open(['route' => ['langcustom.update', $langcustom->id] , 'method' => 'PUT', 'class' => 'form-horizontal', 'langcustom' => 'form'])
                                        !!}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">{{ translate('Change key translate')}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="box-body ">
                                                <div class="">
                                                    <div class="form-group">
                                                        <label for="Key">Key</label>
                                                        <input type="text" name="key" value="{{isset($langcustom->key) ? $langcustom->key : ''}}" class="form-control" id="key" placeholder="key">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="en">En</label>
                                                        <input type="text" name="en" value="{{isset($langcustom->en) ? $langcustom->en : ''}}" class="form-control" id="en" placeholder="en">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vi">Vi</label>
                                                        <input type="text" name="vi" value="{{isset($langcustom->vi) ? $langcustom->vi : ''}}" class="form-control" id="vi" placeholder="vi">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 text-right">
                        {{ $langcustoms->appends(request()->all())->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
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
    $('.change').on('click', function() {
        var key = $('.wrap-content').length;
        $('.changeas').append(`
            <div class="wrap-content">
                <div class="form-group col-md-4">
                    <label for="Key">Key</label>
                    <input type="text" name="lang[${key}][key]" value=""
                        class="form-control" id="key" placeholder="key">
                </div>
                <div class="form-group col-md-4">
                    <label for="en">En</label>
                    <input type="text" name="lang[${key}][en]" value=""
                        class="form-control" id="en" placeholder="en">
                </div>
                <div class="form-group col-md-4">
                    <label for="vi">Vi</label>
                    <input type="text" name="lang[${key}][vi]" value=""
                        class="form-control" id="vi" placeholder="vi">
                </div>
            </div>`)
    })
</script>
{!! \Html::script('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
{!! \Html::script('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
<script>
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function() {
        $('.select2').select2();
    });
    $('#example1').DataTable({
        "bPaginate": false
    })
</script>
@endsection