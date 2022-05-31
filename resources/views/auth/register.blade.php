<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<div id="app">
    <header-component :csrf="{{ json_encode(csrf_token()) }}"></header-component>
    <div class="container m-auto">
        <form class="w-5/12 m-auto" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mt-8">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <div class="m-auto">
                    <input id="name" type="text" class="form-input @error('name') border-red-500 @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="email" class="form-label">{{ __('E-Mail Address')
                    }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-input @error('email') border-red-500 @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <label for="password" class="form-label">{{ __('Password')
                    }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-input @error('password') border-red-500 @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <label for="password-confirm" class="form-label">{{
                    __('Confirm
                    Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-input" name="password_confirmation"
                        required autocomplete="new-password">
                </div>
            </div>

            <div class="mt-6 mb-0">
                <div>
                    <button type="submit" class="form-submit">
                        {{ __('Register') }}
                    </button>
                </div>
                <div class="mt-4">
                    @if (Route::has('login'))
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
