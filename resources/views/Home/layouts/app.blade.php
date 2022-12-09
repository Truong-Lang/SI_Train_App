<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ __('Học Lập Trình PHP Cơ Bản') }}</title>
    <link rel="icon"  href="{{ asset('img') }}/favicon.ico" sizes="32x32" />
    <link rel="icon"  href="{{ asset('img') }}/favicon.ico" sizes="192x192" />
    <link href="{{ asset('css') }}/main.css" rel="stylesheet" media="all"/>
    <link href="{{ asset('css') }}/app.css" rel="stylesheet" media="all"/>
    <link href="{{ asset('css') }}/ocean.css" rel="stylesheet" media="all"/>
</head>
<body>
@include(\App\Common\Constant::FOLDER_URL_HOME . '.layouts.header')
@yield('content')
@include(\App\Common\Constant::FOLDER_URL_HOME . '.layouts.footer')

<script src="{{ asset('js') }}/home/app.js"></script>
<button onclick="animateToTop(event)" id="myBtn" title="Go to top">Top</button>
</body>
</html>