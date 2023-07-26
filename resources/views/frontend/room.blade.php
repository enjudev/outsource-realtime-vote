<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/app.css?v=' . mt_rand(0, 100000)) }}" rel="stylesheet">
    <style>
        html {
            font-family: 'Quicksand', sans-serif !important;
        }
    </style>
</head>

<body class="bg-[#ebebeb] relative">
    <div class="popupInfo fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        style="display: block">
        <div class="w-full rounded-lg bg-black py-[15px] px-[15px] border-[1px] border-white">
            <img class="mx-auto object-cover w-full h-[320px]"
                src="https://vote.ommani.vn/upload/images/tran-thi-nhat-anh.jpg" alt="">
            <div class="grid grid-cols-2 gap-[10px]">
                <h1 class="mt-3 text-[18px] text-white font-[700] text-start">
                    ${value.name}
                </h1>
                <p class="mt-3 text-sm font-[500] text-start text-white">
                    SBD: ${value.sbd}
                </p>
                <p class="mt-3 text-sm font-[500] text-start text-white">
                    Quê Quán: ${value.address}
                </p>
                <p class="mt-3 text-sm font-[500] text-start text-white">
                    Phòng Ban: ${value.department}
                </p>
                <p class="mt-3 text-sm font-[500] text-start text-white">
                    Chiều Cao: ${value.height}
                </p>
                <p class="mt-3 text-sm font-[500] text-start text-white">
                    Sở Thích: ${value.hobby}
                </p>
                <p class="mt-3 text-sm font-[500] text-start text-white">
                    Tiết Mục: ${value.set}
                </p>
            </div>
            <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
                <p class="text-white font-[700] text-base text-center">Quay lại bình chọn</p>
            </button>
        </div>
    </div>
    <div class="alertSuccess fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        style="display: none">
        <div class="w-full bg-white rounded-lg py-[28px] px-[20px]">
            <img class="mx-auto" src="{{ asset('theme/frontend/icon-xanh.svg') }}" alt="">
            <h1 class="mt-4 text-base font-[500] text-center">Gửi bình chọn thành công
            </h1>
            <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
                <p class="text-white font-[700] text-base text-center">Xem kết quả</p>
            </button>
        </div>
    </div>
    <div class="alertError fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        style="display: none">
        <div class="w-full bg-white rounded-lg py-[28px] px-[20px]">
            <img class="mx-auto" src="{{ asset('theme/frontend/icon-do.svg') }}" alt="">
            <h1 class="mt-4 text-base font-[500] text-center">
                Vui lòng bình chọn ít nhất một thí sinh để gửi bình chọn
            </h1>
            <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
                <p class="text-white font-[700] text-base text-center">Quay lại bình chọn</p>
            </button>
        </div>
    </div>
    <section class="min-h-screen bg-no-repeat bg-cover relative"
        style="background-image: url({{ asset('theme/frontend/bg.png') }})">
        <div
            class="border-[1px] pb-[150px] py-[40px] border-white/20 w-full lg:w-[375px] mx-auto px-[15px] min-h-screen relative">
            <h1 class="text-base text-white leading-[20px] text-center font-[400]">Bình chọn ngay thí sinh yêu thích cho
                cuộc thi
                King & Queen
                ISOCERT 2023</h1>
            <h1 class="roundName mt-5 text-[28px] font-[700] leading-[30px] text-center"
                style="background-image: linear-gradient(10deg, #F6F6F6, #F8BB45, #ffff00, #BB8722, #FFFFFF, #FEFAF1);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;">
                Vòng 1: Bình chọn</h1>
            <div>
                <div class="optionContainer grid grid-cols-1 mt-6 gap-[16px] rounded-[8px]">
                </div>
                <div class="py-[12px] px-[15px] bg-[#004C73] mt-10">
                    <img class="object-contain mx-auto" src="{{ asset('theme/frontend/logo.svg') }}" alt="">
                </div>
                <p class="text-center mt-[10px] text-white text-[12px]">Bản quyền © 2023 bởi Ommani. All rights
                    reserved.</p>
            </div>
        </div>
    </section>
    <div class="fixed bottom-0 z-10 w-full left-0 cursor-pointer submitVote"
        style="background: linear-gradient(10deg, #F6F6F6, #F8BB45,#BB8722,#FFFFFF,#FEFAF1);">
        <h1 class="text-[24px] font-[600] text-white text-center py-[25px]">Gửi bình chọn</h1>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
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
            if (snapshot.val().reset == 1) {
                localStorage.setItem('vote', false);
                window.location.href = `{{ route('room.vote', $model->id) }}`;
            }
            if (snapshot.val().status == 1 && localStorage.getItem('vote') == 'false') {
                localStorage.setItem('vote', false);
                window.location.href = `{{ route('room.vote', $model->id) }}`;
            }
            $('.optionContainer').empty();
            var options = snapshot.val().options;
            var sortOptions = Object.fromEntries(
                Object.entries(options).sort(([, a], [, b]) => b.vote - a.vote)
            );
            $('.roundName').text(snapshot.val().name);
            $.each(sortOptions, function(key, value) {
                $('.optionContainer').append(
                    `                <div data-key="${key}" class="card p-[1px] rounded-[8px] overflow-hidden"
                    style="background: linear-gradient(10deg, #F6F6F6, #F8BB45,#BB8722,#FFFFFF,#FEFAF1);">
                    <div class="flex items-center gap-2 bg-black p-[10px] rounded-[8px]">
                        <img class="object-cover rounded-[8px] w-[80px] h-[80px]"
                            src="${value.avatar}" alt="">
                        <div class="flex-1">
                            <h1 class="text-base font-[700] text-white">${value.name}</h1>
                            <p class="font-[500] text-sm text-white">SBD: ${value.sbd}</p>
                            <p class="text-sm p-2 text-white w-full rounded-[6px] mt-1 bg-[#9E9E9E]">Số người bình chọn: <strong>${value.vote}</strong></p> 
                        </div>
                    </div>
                </div>    <div class="popupInfo fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        style="display: none">
        <div class="w-full bg-white rounded-lg py-[28px] px-[20px] overflow-auto h-full">
            <img class="mx-auto" src="${value.avatar}" alt="">
            <h1 class="mt-4 text-base font-[600] text-start">
                Tên: ${value.name}
            </h1>
            <p class="mt-4 text-sm font-[500] text-start">
                SBD: ${value.sbd}
            </p>
            <p class="mt-4 text-sm font-[500] text-start">
                Quê Quán: ${value.address}
            </p>
            <p class="mt-4 text-sm font-[500] text-start">
                Phòng Ban: ${value.department}
            </p>
            <p class="mt-4 text-sm font-[500] text-start">
                Chiều Cao: ${value.height}
            </p>
            <p class="mt-4 text-sm font-[500] text-start">
                Sở Thích: ${value.hobby}
            </p>
            <p class="mt-4 text-sm font-[500] text-start">
                Tiết Mục: ${value.set}
            </p>
            <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
                <p class="text-white font-[700] text-base text-center">Quay lại bình chọn</p>
            </button>
        </div>
    </div>`
                );
            });
            //         if (snapshot.val().status == 0) {
            //             $.each(sortOptions, function(key, value) {
            //                 $('.optionContainer').append(
            //                     `<div data-key="${key}" class="card p-[1px] rounded-[8px] overflow-hidden"
        //                 style="background: linear-gradient(10deg, #F6F6F6, #F8BB45,#BB8722,#FFFFFF,#FEFAF1);">
        //                 <div class="flex items-center gap-2 bg-black p-[10px] rounded-[8px]">
        //                     <img class="object-cover rounded-[8px] object-square w-[80px]"
        //                         src="${value.avatar}" alt="">
        //                     <div class="flex-1">
        //                         <h1 class="text-base font-[700] text-white">${value.name}</h1>
        //                         <p class="font-[500] text-sm text-white">SBD: ${value.sbd}</p>
        //                         <p class="text-sm p-2 text-white w-full rounded-[6px] mt-1 bg-[#9E9E9E]">Số người bình chọn: <strong>${value.vote}</strong></p> 
        //                     </div>
        //                 </div>
        //             </div> <div class="popupInfo fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        //     style="display: none">
        //     <div class="w-full bg-white rounded-lg py-[28px] px-[20px] overflow-auto h-full">
        //         <img class="mx-auto" src="${value.avatar}" alt="">
        //         <h1 class="mt-4 text-base font-[600] text-start">
        //             Tên: ${value.name}
        //         </h1>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             SBD: ${value.sbd}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Quê Quán: ${value.address}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Phòng Ban: ${value.department}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Chiều Cao: ${value.height}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Sở Thích: ${value.hobby}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Tiết Mục: ${value.set}
        //         </p>
        //         <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
        //             <p class="text-white font-[700] text-base text-center">Quay lại bình chọn</p>
        //         </button>
        //     </div>
        // </div>`
            //                 );
            //             });
            //         }
            //         if (snapshot.val().status == 1) {
            //             if (localStorage.getItem('vote') == 'true') {
            //                 $.each(sortOptions, function(key, value) {
            //                     $('.optionContainer').append(
            //                         `<div data-key="${key}" class="card p-[1px] rounded-[8px] overflow-hidden"
        //                 style="background: linear-gradient(10deg, #F6F6F6, #F8BB45,#BB8722,#FFFFFF,#FEFAF1);">
        //                 <div class="flex items-center gap-2 bg-black p-[10px] rounded-[8px]">
        //                     <img class="object-cover rounded-[8px] object-square w-[80px]"
        //                         src="${value.avatar}" alt="">
        //                     <div class="flex-1">
        //                         <h1 class="text-base font-[700] text-white">${value.name}</h1>
        //                         <p class="font-[500] text-sm text-white">SBD: ${value.sbd}</p>
        //                         <p class="text-sm p-2 text-white w-full rounded-[6px] mt-1 bg-[#9E9E9E]">Số người bình chọn: <strong>${value.vote}</strong></p> 
        //                     </div>
        //                 </div>
        //             </div> <div class="popupInfo fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        //     style="display: none">
        //     <div class="w-full bg-white rounded-lg py-[28px] px-[20px] overflow-auto h-full">
        //         <img class="mx-auto" src="${value.avatar}" alt="">
        //         <h1 class="mt-4 text-base font-[600] text-start">
        //             Tên: ${value.name}
        //         </h1>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             SBD: ${value.sbd}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Quê Quán: ${value.address}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Phòng Ban: ${value.department}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Chiều Cao: ${value.height}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Sở Thích: ${value.hobby}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Tiết Mục: ${value.set}
        //         </p>
        //         <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
        //             <p class="text-white font-[700] text-base text-center">Quay lại bình chọn</p>
        //         </button>
        //     </div>
        // </div>`
            //                     );
            //                 });
            //             }
            //             if (localStorage.getItem('vote') != 'true') {
            //                 $.each(sortOptions, function(key, value) {
            //                     $('.optionContainer').append(
            //                         `                <div data-key="${key}" class="card p-[1px] rounded-[8px] overflow-hidden"
        //                 style="background: linear-gradient(10deg, #F6F6F6, #F8BB45,#BB8722,#FFFFFF,#FEFAF1);">
        //                 <div class="flex items-center gap-2 bg-black p-[10px] rounded-[8px]">
        //                     <img class="object-cover rounded-[8px] w-[80px] h-[80px]"
        //                         src="${value.avatar}" alt="">
        //                     <div>
        //                         <h1 class="text-base font-[700] text-white">${value.name}</h1>
        //                         <p class="font-[500] text-sm text-white">SBD: ${value.sbd}</p>
        //                     </div>
        //                     <input type="hidden" class="voteInput" name="vote[]">
        //                     <div class="ml-auto w-[30px] h-[30px] mr-3 cursor-pointer">
        //                         <img class="object-contain w-full h-full addVote"
        //                         src="{{ asset('theme/frontend/untick.svg') }}" alt="">
        //                         <img class="object-contain w-full h-full removeVote" style="display:none"
        //                         src="{{ asset('theme/frontend/tick.svg') }}" alt="">
        //                     </div>
        //                 </div>
        //             </div>    <div class="popupInfo fixed left-0 top-0 h-screen w-full bg-black/40 z-20 items-center p-[15px]"
        //     style="display: none">
        //     <div class="w-full bg-white rounded-lg py-[28px] px-[20px] overflow-auto h-full">
        //         <img class="mx-auto" src="${value.avatar}" alt="">
        //         <h1 class="mt-4 text-base font-[600] text-start">
        //             Tên: ${value.name}
        //         </h1>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             SBD: ${value.sbd}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Quê Quán: ${value.address}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Phòng Ban: ${value.department}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Chiều Cao: ${value.height}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Sở Thích: ${value.hobby}
        //         </p>
        //         <p class="mt-4 text-sm font-[500] text-start">
        //             Tiết Mục: ${value.set}
        //         </p>
        //         <button type="button" class="bg-[#3DBDFF] rounded-[8px] py-[9px] mt-5 w-full closeAlert">
        //             <p class="text-white font-[700] text-base text-center">Quay lại bình chọn</p>
        //         </button>
        //     </div>
        // </div>`
            //                     );
            //                 });
            //             }
            //         }
        });
        $(document).on('click', '.addVote', function(e) {
            e.stopPropagation()
            $(this).css('display', 'none');
            $(this).next().css('display', 'block');
            var key = $(this).closest('.card').data('key');
            $(this).parent().prev().val(key);
        })
        $(document).on('click', '.removeVote', function(e) {
            e.stopPropagation()
            $(this).css('display', 'none');
            $(this).prev().css('display', 'block');
        })
        $(document).on('click', '.closeAlert', function() {
            $(this).closest('.alertSuccess').css('display', 'none');
            $(this).closest('.alertError').css('display', 'none');
            $(this).closest('.popupInfo').css('display', 'none');
        })
        $(document).on('click', '.card', function() {
            $(this).next().css('display', 'block');
        })
        $(document).on('click', '.submitVote', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var key = $(this).parent().data('key');
            var votes = [];
            $('input[name="vote[]"]').each(function() {
                var vote = $(this).val().trim();

                if (vote !== '') {
                    votes.push(vote);
                }
            });
            localStorage.setItem('vote', true);
            if (votes.length === 0) {
                $('.alertError').css('display', 'flex');
            } else {
                $.ajax({
                    url: `{{ route('room.submitVote') }}`,
                    method: 'POST',
                    data: {
                        _token: token,
                        roomId: roomId,
                        key: key,
                        vote: votes
                    },
                    success: function() {
                        $('.alertSuccess').css('display', 'flex');
                    }
                })
            }

        });
    </script>
</body>

</html>
