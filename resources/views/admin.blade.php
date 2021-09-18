<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="theme-color" content="#000000" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="public/assets/fonts/fontawesome/css/fontawesome-all.css">
        <link rel="stylesheet" href="public/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="public/assets/player/style.css">
        <link rel="stylesheet" href="{{asset('public/css/app.css')}}" />
        <link href="public/tailwind.css" rel="stylesheet">
    
        <link rel="shortcut icon" href="/assets/img/favicon.ico" />
        <link
          rel="apple-touch-icon"
          sizes="76x76"
          href="/assets/img/apple-icon.png"
        />
        <title></title>
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>

        <script src="{{asset('public/js/app.js')}}"></script>
    </body>
</html>