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
                            <input type="text" name="name" value="{{ isset($model) ? $model->name : '' }}"
                                class="form-control" id="name" placeholder="Name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Url</label>
                            <input type="text" name="url"
                                value="{{ isset($model) ? route('room.view', $model->uuid) : '' }}" class="form-control"
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
                        <button type="button" class="disableVote cursor-pointer bg-red-600 px-5 py-3 text-white">Disable
                            Vote</button>
                        <button type="button" class="startVote cursor-pointer bg-green-600 px-5 py-3 text-white">Start
                            Vote</button>
                    </div>
                    <h1 class="status text-red-400 text-center mt-5 mb-5">Session vote chưa được bắt đầu</h1>
                    <div class="flex gap-[30px] items-center">
                        <img src="{{ asset('theme/admin/empty_img.png') }}"
                            class="ckfinderUploadImage cursor-pointer w-[100px]" alt=".." />
                        <input type="text" class="name w-full py-2 px-4 focus-visible:outline-none"
                            placeholder="Tên người được bình chọn">
                        <button type="button"
                            class="addOption w-[100px] bg-blue-500 h-full py-[6px] text-white">Add</button>
                    </div>
                    <div class="mt-5 grid grid-cols-6 gap-[30px] optionContainer">
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
            $('.optionContainer').empty();
            $.each(snapshot.val().options, function(key, value) {
                $('.optionContainer').append(
                    `<div class="relative bg-white p-3 rounded-lg" data-key="${key}"><img class="aspect-square object-cover" src="${value.avatar}" alt=""><h1 class="text-center mt-2">${value.name}</h1><p class="mt-2 text-center">${value.vote} Bình chọn</p><img class="removeOption cursor-pointer hover:scale-110 transition duration-150 absolute top-0 right-0 z-10 w-[30px] h-[30px]" src="{{ asset('theme/admin/close.svg') }}" alt=""></div>`
                );
            });
        });
    </script>
    <script>
        $('.addOption').on('click', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var name = $(this).prev().val();
            var avatar = $(this).prev().prev().attr('src');
            console.log(avatar);
            $.ajax({
                url: `{{ route('room.addOption') }}`,
                method: `POST`,
                data: {
                    _token: token,
                    roomId: roomId,
                    name: name,
                    avatar: avatar
                }
            })
        })
    </script>
    <script>
        $(document).on('click', '.removeOption', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var key = $(this).parent().data('key');
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
    </script>
@endsection
