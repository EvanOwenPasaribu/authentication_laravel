<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My first time broadcasting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite('resources/js/app.js')

    <script>
        $(document).ready(function() {
            Echo.private('group.{{ $id }}')
                .listen('GroupEvent', (event) => {
                    alert("cuket");
                    console.log(event);
                });

        })
    </script>

</body>

</html>
