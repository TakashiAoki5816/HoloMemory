<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container m-auto">
        <header>
        </header>
        <main class="w-11/12 m-auto">
            <div class="flex flex-wrap items-center justify-center">
                @foreach($videos as $key => $video)
                    <div class="m-6">
                        {{-- <p>{{ $video['title'] }}</p> --}}
                        <img src="{{ $video['thumbnails_url'] }}">
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>
