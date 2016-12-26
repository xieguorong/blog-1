<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{ asset('style/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/new.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ asset('style/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="{{ url('/') }}"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k => $v)<a href="{{ $v->nav_url }}"><span>{{ $v->nav_name }}</span><span class="en">{{ $v->nav_alias }}</span></a>@endforeach
    </nav>
</header>
@yield('content')
<footer>
    {!! Config::get('web.copyright') !!} {{ Config::get('web.web_count') }}
</footer>
</body>
</html>
