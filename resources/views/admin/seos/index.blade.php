@extends('admin.layouts.app')
@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('breadcrumb')
<section class="content-header">
    @include('admin.partials.breadcrumbs')
</section>
@endsection

@section('content')

<div class="row">
<div class="col-xs-12">
    <div class="box">
    <div class="box-header">
        <h3 class="box-title"></h3>
        <button type="button" onclick="window.location='{{ route('seo.create') }}'"
        class="btn btn-info">@lang('common.add')</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>Page</th>
            <th>Seo image</th>
            <th>Seo Title</th>
            <th>Seo keywords</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $i= 1; @endphp
            @foreach ($seos as $seo)
            <tr>
                <th scope="row" style="width:20px">{{$seo->id}}</th>
                <td>{{$seo->title}}</td>
            <td style="width:10%">
                <img class="img-fluid" style="width:100%" src="{{asset($seo->seo_image)}}" alt="">
            </td>
            <td>{{$seo->seo_title}}</td>
            <td>{{$seo->seo_keyword}}</td>
            <td>
                <a href="{{ route('seo.edit', $seo->id) }}"><i class="fa fa-fw fa-pencil-square-o"></i></a>
                <a href="#" data-url="{{ route('seo.destroy', $seo->id) }}" class="removeRecord"
                id="{{ $seo->id }}"><i class="fa fa-fw fa-trash"></i></a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        <div class="col-sm-12 text-right">
        {{ $seos->appends(request()->all())->links() }}
        </div>
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->

@endsection()

@section('script')
{!! \Html::script('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
{!! \Html::script('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
<script>
$(function () {
    $('#example1').DataTable({
    "bPaginate": false
    })
    // $('#example2').DataTable({
    //   'paging'      : true,
    //   'lengthChange': false,
    //   'searching'   : false,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // })
});
</script>

@endsection
