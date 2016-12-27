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

        //图文列表5篇，带分页
        $articles = Article::orderBy('art_time', 'desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order', 'asc')->get();

        return view('home.index', compact('pics', 'articles', 'links'));
    }

    public function cate($cate_id)
    {
        //图文列表5篇，带分页
        $articles = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(5);

        //查看次数自增
        Category::where('cate_id', $cate_id)->increment('cate_view');

        $category = Category::find($cate_id);

        $subCates = Category::where('cate_pid', $cate_id)->get();

        return view('home.cate', compact('category', 'articles', 'subCates'));
    }

    public function article($art_id)
    {
        $article = Article::join('category', 'article.cate_id', '=', 'category.cate_id')->where('art_id', $art_id)->first();

        //查看次数自增
        Article::where('art_id', $art_id)->increment('art_view');

        $article['pre'] = Article::where('art_id', '<', $art_id)->orderBy('art_id', 'desc')->first();
        $article['next'] = Article::where('art_id', '>', $art_id)->orderBy('art_id', 'asc')->first();

        $relates = Article::where('cate_id', $article->cate_id)->where('art_id', '<>', $article->art_id)->take(6)->get();

        return view('home.new', compact('article', 'relates'));
    }
}
