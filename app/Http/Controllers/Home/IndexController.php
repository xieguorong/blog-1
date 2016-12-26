<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends CommonController
{
    public function index()
    {
        //点击量最高的六篇的文章
        $pics = Article::orderBy('art_view', 'desc')->take(6)->get();

        //点击量最高的五篇的文章
        $hots = Article::orderBy('art_view', 'desc')->take(5)->get();

        //八条最新发布文章
        $new = Article::orderBy('art_time', 'desc')->take(8)->get();

        //图文列表5篇，带分页
        $articles = Article::orderBy('art_time', 'desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order', 'asc')->get();

        return view('home.index', compact('pics', 'hots', 'new', 'articles', 'links'));
    }

    public function cate($cate_id)
    {
        //图文列表5篇，带分页
        $articles = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(5);

        $category = Category::find($cate_id);

        return view('home.cate', compact('category', 'articles'));
    }

    public function article()
    {
        return view('home.new');
    }
}
