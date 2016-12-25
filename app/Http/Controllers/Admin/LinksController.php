<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Links::orderBy('link_order', 'asc')->paginate(5);

        return view('admin.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.links.add');
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
            'link_name' => 'required',
            'link_url' => 'required',
        ];

        $messages = [
            'link_name.required' => '友情链接名称不能为空！',
            'link_url.required' => '友情链接地址不能为空！',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $result = Links::create($input);
            if ($result) {
                return redirect('admin/links');
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
        $link = Links::find($id);

        return view('admin.links.edit', compact('link'));
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
        $result = Links::where('link_id', $id)->update($input);

        if ($result) {
            return redirect('admin/links');
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
        $result = Links::where('link_id', $id)->delete();
        if ($result) {
            $data = [
                'status' => 0,
                'msg' => '友情链接删除成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！'
            ];
        }

        return $data;
    }

    public function changeOrder()
    {
        $input = Input::all();
        $category = Links::find($input['link_id']);
        $category->link_order = $input['link_order'];
        $result = $category->update();
        if ($result) {
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功！'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败！请稍后重试'
            ];
        }

        return $data;
    }
}
