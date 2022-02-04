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
            <div class="lessons">
                @foreach($videos as $key => $video)
                <div class="lesson">
                    <div class="lesson-header">
                        <div>{{ $video->start_time }}</div>
                        <div>{{ $video->member->name }}</div>
                    </div>
                    <div class="h-[180px]">
                        <a href="https://www.youtube.com/watch?v={{$video->video_id }}">
                            <img src="{{ $video['thumbnails_url'] }}">
                        </a>
                    </div>
                    <div>
                        <a class="lesson-channel-icon"
                            href="https://www.youtube.com/channel/{{ $video->member->channel_id}}">
                            <img src="{{ $video->member->channel_icon_url }}"
                                style="border-radius: 50%; border: 2px#eeac5e solid" width="60" height="60">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>
