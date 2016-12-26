<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        //点击量最高的五篇的文章
        $hots = Article::orderBy('art_view', 'desc')->take(5)->get();

        //八条最新发布文章
        $new = Article::orderBy('art_time', 'desc')->take(8)->get();

        $navs = Nav::all();
        View::share('navs', $navs);
        View::share('hots', $hots);
        View::share('new', $new);
    }
}
