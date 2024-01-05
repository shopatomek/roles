<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js"></script>
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
                <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-gray-900 dark:text-gray-900 ">

                        <h1 class="mb-2 text-gray-100">Chat with OpenAI</h1>


                        <div class="container">

                            <br>

                            <form action="{{ route('chat') }}" method="POST">
                                @csrf
                                <input type="text" name="message" placeholder="Ask me anything..."
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full bg-gray-900">

                                <br>
                                <x-primary-button>
                                    {{ __('Send') }}
                                </x-primary-button>

                            </form>
                            <br>
                            @if (session('response'))
                                <pre><code class="language-php response bg-gray-900 border-l-4 border-blue-500 text-gray-100">
                                <div class="response bg-gray-900 border-l-4 border-blue-500 text-gray-100">
                                        <p class="whitespace-pre-wrap">{{ session('response') }}</p>
                                </div>
                            </code></pre>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>

</body>
<script>
    hljs.highlightAll();
</script>

</html>
