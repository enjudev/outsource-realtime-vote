@extends('admin.layouts.app')
@section('titel', 'Home Admin')
@section('css_global')
    {!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('breadcrumb')
    <section class="content-header">
        <h1>
            {{ isset($title) ? $title : '' }}
            <small>{{ isset($subTile) ? $subTile : '' }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> <a href="{{ route('user.index') }}"> Bộ sản phẩm </a></li>
        </ol>
    </section>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                    <button type="button" onclick="window.location='{{ route('room.create') }}'"
                        class="btn bg-[#3c8dbc] text-white">@lang('common.add')</button>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table-bordered table-striped table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Uuid</th>
                                <th>Ngày tạo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i= 1; @endphp
                            @foreach ($models as $model)
                                <tr>
                                    <th scope="row" style="width:20px">{{ $model->id }}</th>
                                    <td>{{ $model->uuid }}</td>
                                    <td>{{ $model->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('room.edit', $model->id) }}"><i
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        {{-- <a href="{{ route('question.edit', $model->id) }}"><i
                                                class="fa fa-fw fa-pencil-square-o"></i></a> --}}
                                        <a href="#" data-url="{{ route('room.destroy', $model->id) }}"
                                            class="removeRecord" id="{{ $model->id }}"><i
                                                class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 text-right">
                        {{ $models->appends(request()->all())->links('pagination::bootstrap-4') }}
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
        $(function() {
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
