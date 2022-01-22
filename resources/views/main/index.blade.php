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
            <div class="flex flex-wrap items-center justify-start">
                @foreach($videos as $key => $video)
                    <div class="w-320 h-290 m-7 border-2 border-gray-200">
                        <div class="flex items-center justify-between h-40bg-gray-200">
                            <div>{{ $video->scheduled_start_time }}</div>
                            <div>{{ $video->member->name }}</div>
                        </div>
                        <div class="h-180">
                            <a href="https://www.youtube.com/watch?v={{$video->video_id }}">
                                <img src="{{ $video['thumbnails_url'] }}">
                            </a>
                        </div>
                        <div class="h-60">
                            <a class="block w-60 m-auto" href="https://wwwyoutube.com/channel/{{ $video->member->channel_id}}">
                                <img src="{{ $video->member->channel_icon_url}}" style="border-radius: 50%; border: 2px#eeac5e solid" width="60" height="60">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>
