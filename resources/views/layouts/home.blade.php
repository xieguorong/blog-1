<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>陈华个人博客</title>
    <meta name="keywords" content="个人博客模板,博客模板"/>
    <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。"/>
    <link href="{{ asset('style/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/index.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ asset('style/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav"><a href="index.html"><span>首页</span><span class="en">Protal</span></a><a
                href="about.html"><span>关于我</span><span class="en">About</span></a><a
                href="newlist.html"><span>慢生活</span><span class="en">Life</span></a><a
                href="moodlist.html"><span>碎言碎语</span><span class="en">Doing</span></a><a
                href="share.html"><span>模板分享</span><span class="en">Share</span></a><a
                href="knowledge.html"><span>学无止境</span><span class="en">Learn</span></a><a
                href="book.html"><span>留言版</span><span class="en">Gustbook</span></a></nav>
</header>
@yield('content')
<footer>
    <p><a href="http://www.miitbeian.gov.cn/" target="_blank">http://www.chenhua.club</a> <a href="/">网站统计</a>
    </p>
</footer>
<script src="{{ asset('style/js/silder.js') }}"></script>
</body>
</html>
