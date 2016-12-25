<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navs = Nav::orderBy('nav_order', 'asc')->paginate(5);

        return view('admin.nav.index', compact('navs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nav.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');

        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];

        $messages = [
            'nav_name.required' => '导航名称不能为空！',
            'nav_url.required' => '导航地址不能为空！',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $result = Nav::create($input);
            if ($result) {
                return redirect('admin/nav');
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nav = Nav::find($id);

        return view('admin.nav.edit', compact('nav'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token', '_method');
        $result = Nav::where('nav_id', $id)->update($input);

        if ($result) {
            return redirect('admin/nav');
        } else {
            return back()->with('errors', '数据更新失败，请稍后重试！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return mixed
     */
    public function destroy($id)
    {
        $result = Nav::where('nav_id', $id)->delete();
        if ($result) {
            $data = [
                'status' => 0,
                'msg' => '自定义导航删除成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '自定义导航删除失败，请稍后重试！'
            ];
        }

        return $data;
    }

    public function changeOrder()
    {
        $input = Input::all();
        if (!is_numeric($input['nav_order'])) {
            return $data = [
                'status' => 1,
                'msg' => '自定义导航排序只能为数字！'
            ];
        }

        $category = Nav::find($input['nav_id']);
        $category->nav_order = $input['nav_order'];
        $result = $category->update();
        if ($result) {
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '自定义导航排序更新失败！请稍后重试'
            ];
        }

        return $data;
    }
}
