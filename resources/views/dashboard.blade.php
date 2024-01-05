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
                        <div class="container">
                            <h1>Chat with OpenAI</h1>
                            <form action="{{ route('chat') }}" method="POST">
                                @csrf
                                <input type="text" name="message" placeholder="Wpisz swoją wiadomość">
                                <button type="submit">Wyślij</button>
                            </form>

                            @if (session('response'))
                                <div class="response">
                                    <p>{{ session('response') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

</body>

</html>
