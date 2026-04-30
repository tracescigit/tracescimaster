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
    <style>
        .auth-tabs {
            display: flex;
            width: 300px;
            border: 1px solid #333;
        }

        .auth-tabs .tab {
            flex: 1;
            text-align: center;
            padding: 12px 0;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            border: none;
            outline: none;
        }

        /* Active (LOGIN) */
        .auth-tabs .active {
            background: #1e1e1e;
            color: #fff;
        }

        /* Inactive (REGISTER) */
        .auth-tabs .tab:not(.active) {
            background: transparent;
            color: #333;
            border-left: 1px solid #333;
        }

        /* Hover effect */
        .auth-tabs .tab:hover {
            background: #333;
            color: #fff;
        }
    </style>


    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />

</head>

@yield('body')

</html>