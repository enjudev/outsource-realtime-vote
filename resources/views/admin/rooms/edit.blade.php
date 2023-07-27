@extends('admin.layouts.app')

@section('titel', 'Home Admin')
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
        $route = empty($model) ? 'room.store' : ['room.update', $model->id];
        $method = empty($model) ? 'POST' : 'PUT';
    @endphp
    {!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'room' => 'form']) !!}
    <section class="content">
        <div class="row">
            <div class="col-md-9">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Main</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title">Tên</label>
                            <input type="text" name="roomName" value="{{ isset($model) ? $model->name : '' }}"
                                class="form-control" id="name" placeholder="Name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Url</label>
                            <input type="text" name="url"
                                value="{{ isset($model) ? route('room.view', $model->id) : '' }}" class="form-control"
                                id="url" placeholder="url" disabled>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary bg-blue-400">Submit</button>
                    </div>
                </div>
            </div>
            @if (isset($model))
                <div class="col-md-9">
                    <div class="flex items-center gap-5 justify-center">
                        <button type="button" class="disableVote cursor-pointer bg-orange-600 px-5 py-3 text-white">Disable
                            Vote</button>
                        <button type="button" class="startVote cursor-pointer bg-green-600 px-5 py-3 text-white">Start
                            Vote</button>
                        <button type="button" class="resetRound cursor-pointer bg-red-600 px-5 py-3 text-white"
                            style="background-color: red">Reset
                            Round</button>
                    </div>
                    <h1 class="status text-red-400 text-center mt-5 mb-5"></h1>
                    <div class="bg-white p-[15px] rounded-lg">
                        <div class="flex gap-[30px] items-start">
                            <img src="{{ asset('theme/admin/empty_img.png') }}"
                                class="ckfinderUploadImage avatar cursor-pointer w-[200px]" alt=".." />
                            <div class="flex-1 flex flex-col gap-2">
                                <input type="text" class="form-control name w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Tên người được bình chọn">
                                <input type="text" class="form-control sbd w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Số báo danh">
                                <input type="text"
                                    class="form-control address w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Quê Quán">
                                <input type="text"
                                    class="form-control department w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Phòng ban">
                                <input type="text"
                                    class="form-control height w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Chiều cao">
                                <input type="text" class="form-control hobby w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Sở thích">
                                <input type="text" class="form-control set w-full py-2 px-4 focus-visible:outline-none"
                                    placeholder="Tiết mục">
                            </div>
                        </div>
                        <button type="button"
                            class="addOption w-[100px] bg-blue-500 h-full py-[6px] text-white">Thêm</button>
                    </div>
                    <div class="mt-5 grid grid-cols-3 lg:grid-cols-6 gap-[30px] optionContainer">
                    </div>
                </div>
            @endif
            <!--End Row-->
            {!! Form::close() !!}
    </section>
@endsection()

@section('script')
    {!! \Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') !!}
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <script type="text/javascript">
        $('.btn-reset-form').on('click', '', function() {
            //$('.form-horizontal').trigger("reset");
            $('.form-horizontal').on('form-horizontal', function() {
                $(this).find('form')[0].reset();
            });
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
                        $currentElement.attr("src",
                            `{{ asset('${thumbnail.substring(1)}') }}`);
                    });
                },
            });
        })
    </script>
    <script>
        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAw7IV8z--TBadgNcEZkUhYKfH3D3QEayU",
            authDomain: "ommani-voting.firebaseapp.com",
            databaseURL: "https://ommani-voting-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "ommani-voting",
            storageBucket: "ommani-voting.appspot.com",
            messagingSenderId: "525995846949",
            appId: "1:525995846949:web:07c572a4e5b62392ddbecc",
            measurementId: "G-TD5ENPH2QT"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>
    <script>
        // Get a reference to the root of the database
        var database = firebase.database().ref('room{{ isset($model->uuid) ? $model->uuid : '' }}');

        // Set up the event listener for changes in the database
        database.on("value", function(snapshot) {
            if (snapshot.val().status == 1) {
                $('.status').css('color', 'green');
                $('.status').text('Đang trong quá trình vote');
            } else {
                $('.status').css('color', 'red');
                $('.status').text('Session vote chưa được bắt đầu');
            }
            $('.optionContainer').empty();
            $.each(snapshot.val().options, function(key, value) {
                $('.optionContainer').append(
                    `<div class="cursor-pointer relative bg-white p-3 rounded-lg" data-toggle="modal" data-target="#${key}" data-key="${key}"><img class="aspect-square object-cover" src="${value.avatar}" alt=""><h1 class="text-center mt-2">${value.name}</h1><p class="mt-2 text-center">${value.vote} Bình chọn</p><img class="cursor-pointer hover:scale-110 transition duration-150 absolute top-0 right-0 z-10 w-[30px] h-[30px]" src="{{ asset('theme/admin/close.svg') }}" alt=""></div>
                    <div class="modal fade modalContainer" data-key="${key}" id="${key}" tabindex="-1" role="dialog" aria-labelledby="${key}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header flex item-center">
                                <h5 class="modal-title" id="${key}">Chỉnh sửa</h5>
                                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <div class="modal-body modal-form">
                            <img class="ckfinderUploadImage cursor-pointer w-2/3 avatar mx-auto h-[500px] object-cover" src="${value.avatar}" />
                            <div class="grid grid-cols-2 gap-[10px] mt-5">
                                <div>
                                    <p class="text-base mb-1 text-black">Họ và tên</p>
                                    <input name="name" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.name}" />
                                </div>
                                <div>
                                    <p class="text-base mb-1 text-black">Số báo danh</p>
                                    <input name="sbd" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.sbd}" />
                                </div>
                                <div>
                                    <p class="text-base mb-1 text-black">Chiều cao</p>
                                    <input name="height" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.height}" />
                                </div> 
                                <div>
                                    <p class="text-base mb-1 text-black">Địa chỉ</p>
                                    <input name="address" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.address}" />
                                </div>  
                                <div>
                                    <p class="text-base mb-1 text-black">Phòng ban</p>
                                    <input name="department" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.department}" />
                                </div>
                                <div>
                                    <p class="text-base mb-1 text-black">Sở thích</p>
                                    <input name="hobby" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.hobby}" />
                                </div>
                                <div>
                                    <p class="text-base mb-1 text-black">Tiết mục</p>
                                    <input name="set" class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.set}" />
                                </div>  
                                <div>
                                    <p class="text-base mb-1 text-black">Tổng bình chọn</p>
                                    <input name="vote" disabled class="px-4 w-full py-1 border-[1px] border-[#ebebeb]" value="${value.vote}" />
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="removeOption bg-red-400 text-white px-10 py-2" data-dismiss="modal">Xoá</button>
                            <button type="button" class="updateOption ml-4 bg-green-500 text-white py-2 px-10">Lưu thay đổi</button>
                        </div>
                        </div>
                    </div>
                    </div>`
                );
            });
        });
    </script>
    <script>
        $('.addOption').on('click', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var name = $(this).prev().find('.name').val();
            var sbd = $(this).prev().find('.sbd').val();
            var address = $(this).prev().find('.address').val();
            var department = $(this).prev().find('.department').val();
            var height = $(this).prev().find('.height').val();
            var hobby = $(this).prev().find('.hobby').val();
            var set = $(this).prev().find('.set').val();
            var avatar = $(this).prev().find('.avatar').attr('src');
            $.ajax({
                url: `{{ route('room.addOption') }}`,
                method: `POST`,
                data: {
                    _token: token,
                    roomId: roomId,
                    name: name,
                    sbd: sbd,
                    address: address,
                    department: department,
                    height: height,
                    hobby: hobby,
                    set: set,
                    avatar: avatar
                }
            })
        })
    </script>
    <script>
        $(document).on('click', '.updateOption', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var key = $(this).closest('.modalContainer').data('key');
            var formBody = $(this).parent().prev();
            $('.modal').modal('hide');
            $.ajax({
                url: `{{ route('room.updateOption') }}`,
                method: `POST`,
                data: {
                    _token: token,
                    roomId: roomId,
                    key: key,
                    name: formBody.find('input[name="name"]').val(),
                    sbd: formBody.find('input[name="sbd"]').val(),
                    address: formBody.find('input[name="address"]').val(),
                    department: formBody.find('input[name="department"]').val(),
                    height: formBody.find('input[name="height"]').val(),
                    hobby: formBody.find('input[name="hobby"]').val(),
                    set: formBody.find('input[name="set"]').val(),
                    vote: formBody.find('input[name="vote"]').val(),
                    avatar: formBody.find('.avatar').attr('src'),
                }
            })
        })
        $(document).on('click', '.removeOption', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var key = $(this).closest('.modalContainer').data('key');
            $.ajax({
                url: `{{ route('room.removeOption') }}`,
                method: `POST`,
                data: {
                    _token: token,
                    roomId: roomId,
                    key: key
                }
            })
        })
        $(document).on('click', '.startVote', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            $('.status').css('color', 'green');
            $('.status').text('Đang trong quá trình vote');
            $.ajax({
                url: `{{ route('room.startVote') }}`,
                method: `POST`,
                data: {
                    _token: token,
                    roomId: roomId,
                }
            })
        })
        $(document).on('click', '.disableVote', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            $('.status').css('color', 'red');
            $('.status').text('Session vote chưa được bắt đầu');
            $.ajax({
                url: `{{ route('room.disableVote') }}`,
                method: `POST`,
                data: {
                    _token: token,
                    roomId: roomId,
                }
            })
        })
        $(document).on('click', '.resetRound', function() {
            swal({
                    title: "Bạn có chắc chắn không?",
                    text: "Sau khi khôi phục lại, bạn sẽ mất hết dữ liệu !!!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
                        var token = $('meta[name="csrf-token"]').attr('content');
                        $('.status').css('color', 'red');
                        $('.status').text('Phiên vote đang được đặt lại');
                        $.ajax({
                            url: `{{ route('room.resetRound') }}`,
                            method: `POST`,
                            data: {
                                _token: token,
                                roomId: roomId,
                            }
                        })
                    }
                });
        })
    </script>
@endsection
