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
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>{{translate('Name')}}</th>
            <th>Email</th>
            <th>{{translate('PhoneNumber')}}</th>
            <th>{{translate('Address')}}</th>
            <th>{{translate('Published')}}</th>
            <th>{{translate('Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @php $i= 1; @endphp
            @foreach ($contacts as $contact)
            <tr>
            <th scope="row" style="width:20px">{{$contact->id}}</th>
            <td>{{$contact->contact_name}}</td>
            <td>{{$contact->contact_email}}</td>
            <td>{{$contact->contact_phone}}</td>
            <td>{{$contact->contact_address}}</td>
            <td>
                @if($contact->contact_published == '0')
                    <span class="text-danger">Chưa xem</span>
                @else
                    <span class="text-success">Đã xem</span>
                @endif
            </td>
            <td>
                <a  data-toggle="modal" data-target="#flipFlop{{ $contact->id }}" class="cursor-pointer"><i class="fa fa-eye"></i></a>
                <a href="#" data-url="{{ route('contact.destroy', $contact->id) }}" class="removeRecord"
                id="{{ $contact->id }}"><i class="fa fa-fw fa-trash"></i></a>
            </td>
            </tr>
            <div class="modal fade" id="flipFlop{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {!! Form::open(['route' => ['contact.update', $contact->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'contact' => 'form'])
                    !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="contact_name">{{translate('Full Name')}}</label>
                                <input type="text" name="contact_name" value="{{isset($contact) ? $contact->contact_name : ''}}"
                                    class="form-control" id="contact_name" disabled>
                            </div>
                            <div class="form-group">
                                <label for="contact_email">Email</label>
                                <input type="email" name="contact_email" value="{{isset($contact)? $contact->contact_email : ''}}"
                                    class="form-control" id="contact_email" disabled>
                            </div>
                            <div class="form-group">
                                <label for="contact_phone">{{translate('Phone Number')}}</label>
                                <input type="text" name="contact_phone" value="{{isset($contact)? $contact->contact_phone : ''}}"
                                    class="form-control" id="contact_phone" disabled>
                            </div>
                            <div class="form-group">
                                <label for="contact_address">{{translate('Address')}}</label>
                                <input type="text" name="contact_address" value="{{isset($contact->contact_address)? $contact->contact_address : ''}}"
                                    class="form-control" id="contact_address" disabled>
                            </div>
                            <div class="form-group">
                                <label class="contact_published">{{translate('Published')}}</label>
                                <select class="select2 form-control" style="width: 100%;" name="contact_published">
                                    @foreach($statusData as $data)
                                    @if(isset($contact))
                                    <option class="text-black font-medium" value="{{$data['value']}}" {{$contact->contact_published ==
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" >Update</button>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
                </div>
            @endforeach
        </tbody>
        </table>
        <div class="col-sm-12 text-right">
        {{ $contacts->appends(request()->all())->links() }}
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
