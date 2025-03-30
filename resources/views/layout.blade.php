<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Page</title>
    @yield('in_head')
    @stack('head_stack')
</head>

<body class=" {{ $classPage ?? '' }}">

@yield('bodycontent')

<script>window.config = @json(['locale' => $locale = app()->getLocale(), 'baseUrl' => $locale = app()->make('url')->to('/')]);</script>
@yield('end_body')
@stack('after_script')
</body>
</html>
