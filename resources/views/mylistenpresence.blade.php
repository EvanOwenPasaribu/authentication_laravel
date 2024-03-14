<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My first time broadcasting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div>
        <ul id="chat-list">

        </ul>
        <form id="form" class="w-100 d-flex flex-col">
            <span class="pl-1" id="span-typing"></span>
            <input id="input-message" class="py-2 pl-1" placeholder="Type a message" type="text">
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite('resources/js/app.js')

    <script>
        $(document).ready(function() {
            const form = document.getElementById('form');
            const inputMessage = document.getElementById('input-message');
            const spanTyping = document.getElementById('span-typing');

            const channel = Echo.join('presence.1');

            inputMessage.addEventListener('input', function(event) {
                if (inputMessage.value.length === 0) {
                    console.log('stop');
                    channel.whisper('stop-typing', {
                        email: '{{ auth()->user()->name }}'
                    })
                } else {
                    console.log('aa');
                    channel.whisper('typing', {
                        email: '{{ auth()->user()->name }}'
                    })
                }
            })

            channel.here((users) => {
                    console.log({
                        users
                    })
                    console.log('subscribedd!');
                })
                .joining((user) => {
                    console.log({
                        user
                    }, 'joined')
                    $("#chat-list").append(`<li>${user.name} - join</li>`)
                })
                .leaving((user) => {
                    console.log({
                        user
                    }, 'leaving')
                    $("#chat-list").append(`<li>${user.name} - leaving</li>`)
                })
                .listen('.presence-testing-event', (event) => {
                    console.log(event);
                    const message = event.message;
                    const user = event.user;
                    $("#chat-list").append(`<li>${user.name} - ${message}</li>`)
                })
                .listenForWhisper('typing', (event) => {
                    console.log('typing')
                    spanTyping.textContent = event.email + ' is typing...';
                })
                .listenForWhisper('stop-typing', (event) => {
                    console.log('stop_typing')
                    spanTyping.textContent = "";
                })

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                channel.whisper('stop-typing', {
                    email: '{{ auth()->user()->name }}'
                })

                const userInput = inputMessage.value;

                axios.post('/eventpresence/1', {
                    message: userInput
                })

                inputMessage.value = "";

            });

        })
    </script>

</body>

</html>
