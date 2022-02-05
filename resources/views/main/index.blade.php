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
    <div class="w-full">
        <header class="header">
            <h1>HoloMemory</h1>
        </header>
        <div class="container m-auto">

            <main class="w-11/12 m-auto">
                <div class="lessons">
                    @foreach ($videos as $key => $video)
                    {{-- 日付の境界線チェック --}}
                    @if ($key === 0 || substr($videos[$key]["scheduled_start_time"], 5, 5) !=
                    substr($videos[$key-1]["scheduled_start_time"], 5, 5))
                    <div class="date-section">
                        <h2 class="text-white text-center leading-[60px]">{{ $video->start_date }}</h2>
                    </div>
                    @endif
                    <div class="lesson">
                        <div class="lesson-header">
                            <div>{{ $video->start_time }}</div>
                            <div>{{ $video->member->name }}</div>
                        </div>
                        <div class="lesson-image">
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
    </div>
</body>

</html>
