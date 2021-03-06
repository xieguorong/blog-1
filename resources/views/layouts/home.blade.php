<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    @section('css')
        <link href="{{ asset('style/css/base.css') }}" rel="stylesheet">
    @show
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
@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $n)
            <li><a href="{{ url('a/'.$n->art_id) }}" title="{{ $n->art_title }}" target="_blank">{{ $n->art_title }}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hots as $hot)
            <li><a href="{{ url('a/'.$hot->art_id) }}" title="{{ $hot->art_title }}" target="_blank">{{ $hot->art_title }}</a></li>
        @endforeach
    </ul>
@show
<footer>
    {!! Config::get('web.copyright') !!} {{ Config::get('web.web_count') }}
</footer>
</body>
</html>
