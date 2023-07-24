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
        <div style="display: flex;align-items: center;width: 21%;">
            <p type="button" class="btn  btn-warning" style="min-width:250px; margin-right:10px;">Đang chờ duyêt({{$countCommentNoActive}})</p>
            <p type="button" class="btn  btn-success" style="min-width:250px;">Đã duyệt({{$countCommentActive}})</p>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Time</th>
            <th>Content</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $i= 1; @endphp
            @foreach ($postcomments as $postcomment)
            <tr>
            <th scope="row" style="width:20px">{{$postcomment->id}}</th>
            <td>{{$postcomment->author}}</td>
            <td>{{$postcomment->timeAgo}}</td>
            <td>{!! $postcomment->content !!}</td>
            <td>
                @if($postcomment->published == 1)
                    <span class="label label-success" data-toggle="modal" data-target="#change{{$postcomment->id}}" style="cursor:pointer;">Active</span>
                @else 
                    <span class="label label-danger" data-toggle="modal" data-target="#change{{$postcomment->id}}" style="cursor:pointer;">No active</span>
                @endif
                <div class="modal fade" id="change{{$postcomment->id}}" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Change Status</h4>
                            </div>
                            {!! Form::open(['route' => ['postcomment.update', $postcomment->id], 'method' => 'PUT', 'postcomment' => 'form'])
                            !!}
                            <div class="modal-body">
                                <div class="form-group" style="width:100%;">
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
                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
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
            </td>
            <td>
                <a href="#" data-url="{{ route('postcomment.destroy', $postcomment->id) }}" class="removeRecord"
                id="{{ $postcomment->id }}"><i class="fa fa-fw fa-trash"></i></a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        <div class="col-sm-12 text-right">
        {{ $postcomments->appends(request()->all())->links() }}
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
