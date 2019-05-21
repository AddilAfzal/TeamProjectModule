<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{$title}} - AirVia</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Loading Flat UI -->
        <link href="/css/flat-ui.min.css" rel="stylesheet">

        <!-- Loading Custom Styling -->
        <link href="/css/custom.css" rel="stylesheet">

        <!-- Loading Font Awesome -->
        <link rel="stylesheet" href="/css/font-awesome.min.css">

        <!-- Loading Footer -->
        <link rel="stylesheet" href="/css/sticky-footer.css">

        <link rel="shortcut icon" href="img/favicon.ico">
        <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
        <script src="/js/vendor/jquery.min.js"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
        <script src="/js/vendor/html5shiv.js"></script>
        <script src="/js/vendor/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        @if(auth()->check())
            @include(auth()->user()->role . '.nav')
        @else
            @include('guest.nav')
        @endif

        @yield('content')

        @include('layouts.footer')

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/js/vendor/video.js"></script>
        <script src="/js/flat-ui.min.js"></script>

    </body>

</html>
