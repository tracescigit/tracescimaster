<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $dark_mode ? 'dark' : '' }}">

<head>
    <meta charset="utf-8">
    <link href="{{asset('web/images/favicon.ico')}}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TRACESCI">
    <meta name="author" content="VKREATE">
    @yield('head')



    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />

</head>

@yield('body')

</html>