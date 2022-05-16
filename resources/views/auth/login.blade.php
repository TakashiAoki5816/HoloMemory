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
        <form class="w-5/12 m-auto" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mt-8">
                <label for="email" class="form-label">{{ __('E-Mail
                    Address')
                    }}</label>
                <div class="m-auto">
                    <input id="email" type="email" class="form-input w-11/12 @error('email') border-red-500 @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                    <input id="password" type="password"
                        class="form-input w-11/12 @error('password') border-red-500 @enderror" name="password" required
                        autocomplete="current-password">

                    @error('password')
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="flex items-start mt-6">
                <div class="flex items-center h-5">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
                        ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <div class="mt-6">
                <div>
                    <button type="submit" class="form-submit">
                        {{ __('Login') }}
                    </button>
                </div>
                <div class="block mt-4">
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                    @if (Route::has('password.request'))
                    <a class="ml-6" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
