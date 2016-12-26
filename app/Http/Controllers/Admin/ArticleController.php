<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('art_id', 'desc')->paginate(10);

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.article.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];

        $messages = [
            'art_title.required' => '文章标题不能为空！',
            'art_content.required' => '文章内容不能为空！',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $result = Article::create($input);
            if ($result) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = (new Category())->tree();
        $article = Article::find($id);

        return view('admin.article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token', '_method');
        $result = Article::where('art_id', $id)->update($input);

        if ($result) {
            return redirect('admin/article');
        } else {
            return back()->with('errors', '数据更新失败，请稍后再试！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        $result = Article::where('art_id', $id)->delete();
        if ($result) {
            $data = [
                'status' => 0,
                'msg' => '文章删除成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '分类删除失败，请稍后再试！'
            ];
        }

        return $data;
    }
}
