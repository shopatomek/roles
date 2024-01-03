<!DOCTYPE html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <x-app-layout>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="chat">
                            <div class="top">
                                <div>
                                    <p>Admin test</p>
                                    <small>Online</small>
                                </div>
                            </div>
                        </div>

                        <div class="messages text-stone-100">
                            <div class="left message">
                                <!-- <img src="/storage/avatar.png" style="width: 40px; height: 40px" alt=""> -->
                                <br>
                                <p>Start chatting with Chat GPT AI below!!</p>
                            </div>
                        </div>
                        <br>

                        <div class="bottom" >
                            <form>
                                <input style="color:darkblue" type="text" id="message" name="message" placeholder="Enter message.." autocomplete="off">
                                <button type="submit" style="color:aliceblue; border:1px white solid; margin: 2px">submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

</body>

<script>
    $("form").submit(function(event) {
        event.preventDefault();
        $("form #message").prop('disabled', true);
        $("form button").prop('disabled', true);

        $.ajax({
            url: "/dashboard/chat", 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                "content": $("form #message").val()
            }
        }).done(function(res) {
            $(".messages > .message").last().after('<div class="right message">' +
                '<p>' + $("form #message").val() + '</p>' + '</div>');

            $(".messages > .message").last().after('<div class="right message">' +
                '<p>' + res.choices[0].message.content + '</p>' + '</div>');

            $("form #message").val('');
            $(document).scrollTop($(document).height());
            $("form #message").prop('disabled', false);
            $("form button").prop('disabled', false);
        });
    });
</script>


</html>