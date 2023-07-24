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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html {
            font-family: 'Quicksand', sans-serif !important;
        }
    </style>
</head>

<body class="bg-[#ebebeb]">
    <section>
        <div class="container mx-auto">
            <h1 class="text-[60px] text-center font-[500]">{{ $model->name }}</h1>
            <div class="optionContainer grid grid-cols-6 mt-10 gap-[30px]"></div>
        </div>
    </section>
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
            $('.optionContainer').empty();
            $.each(snapshot.val().options, function(key, value) {
                $('.optionContainer').append(
                    `<div data-key="${key}" class="bg-white rounded-lg overflow-hidden"><img class="aspect-square object-cover" src="${value.avatar}" alt=""><h1 class="text-center mt-2">${value.name}</h1><p class="mt-2 text-center">Vote ${value.vote}</p><div class="py-2 mt-3 text-center bg-blue-400 cursor-pointer text-white submitVote">Vote Button</div></div>`
                );
            });
        });
        $(document).on('click', '.submitVote', function() {
            var roomId = `{{ isset($model->uuid) ? $model->uuid : '' }}`;
            var token = $('meta[name="csrf-token"]').attr('content');
            var key = $(this).parent().data('key');
            $.ajax({
                url: `{{ route('room.submitVote') }}`,
                method: 'POST',
                data: {
                    _token: token,
                    roomId: roomId,
                    key: key
                }
            })
        });
    </script>
</body>

</html>
