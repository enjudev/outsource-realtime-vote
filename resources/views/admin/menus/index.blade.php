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
        <button type="button" onclick="window.location='{{ route('menu.create') }}'"
        class="btn btn-info">@lang('common.add')</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Url</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $i= 1; $categoryTree = builderCategoryTree($menus);@endphp
            @foreach ($categoryTree as $menu)
            <tr>
            <th scope="row" style="width:20px">{{$i++}}</th>
            <td>{{$menu->name}}</td>
            <td>{{$menu->url}}</td>
            <td>
                @if($menu->status == 1) 
                    <span class="label label-success" >Hiện</span></span>
                @else 
                    <span class="label label-danger">Ẩn</span>
                @endif
                
            </td>
            <td>
                <a href="{{ route('menu.show', $menu->id) }}"><i class="fa fa-fw fa-user"></i></a>
                <a href="{{ route('menu.edit', $menu->id) }}"><i class="fa fa-fw fa-pencil-square-o"></i></a>
                <a href="#" data-url="{{ route('menu.destroy', $menu->id) }}" class="removeRecord"
                id="{{ $menu->id }}"><i class="fa fa-fw fa-trash"></i></a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        <div class="col-sm-12 text-right">
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
