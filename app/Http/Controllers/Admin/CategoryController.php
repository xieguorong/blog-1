<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = (new Category())->tree();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin/category/add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $rules = [
            'cate_name' => 'required'
        ];

        $messages = [
            'cate_name.required' => '分类名称不能为空！',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $result = Category::create($request->except('_token'));
            if ($result) {
                return redirect('admin/category');
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
        $field = Category::find($id);
        $categories = Category::all();

        return view('admin.category.edit', compact('field', 'categories'));
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
        $result = Category::where('cate_id', $id)->update($request->except('_method', '_token'));

        if ($result) {
            return redirect('admin/category');
        } else {
            return back()->with('errors', '数据更新失败，请稍后重试！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function changeOrder()
    {
        $input = Input::all();
        $category = Category::find($input['cate_id']);
        $category->cate_order = $input['cate_order'];
        $result = $category->update();
        if ($result) {
            $data = [
                'status' => 0,
                'msg' => '数据更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '数据更新失败！请稍后重试'
            ];
        }

        return $data;
    }
}
