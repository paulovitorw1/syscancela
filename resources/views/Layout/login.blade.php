<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login Syscancela IFCE</title>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="{{ asset('libs/css/semantic.min.css') }}"/>
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('libs/css/semantic.css') }}"/> --}}
        <link href="{{ asset('img/favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />   
        <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}"/>
        <script type="text/javascript" src="{{ asset('libs/js/semantic.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('libs/js/jquery-ui.min.js') }}"></script>
    </head>
    <body>
        <div id="ui container">
            @yield('content')
        </div>
    </body>
</html>
