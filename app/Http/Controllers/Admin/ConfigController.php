<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = Config::orderBy('conf_order', 'asc')->paginate(5);
        foreach ($configs as $config) {
            switch ($config->field_type) {
                case 'input':
                    $config->_html = '<input class="lg" type="text" name="conf_content[]" value="'. $config->conf_content .'">';
                    break;
                case 'textarea':
                    $config->_html = '<textarea class="lg" name="conf_content[]">'. $config->conf_content .'</textarea>';
                    break;
                case 'radio':
                    $radios = explode(',', $config->field_value);
                    $config->_html = '';
                    foreach ($radios as $radio) {
                        $arr = explode('|', $radio);
                        $c = $config->conf_content == $arr[0] ? 'checked' : '';
                        $config->_html .= '<input type="radio" name="conf_content[]" value="'. $arr[0] .'" '. $c .'>' . $arr[1] . "&nbsp;&nbsp;";
                    }
                    break;
            }
        }

        return view('admin.config.index', compact('configs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.config.add');
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
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];

        $messages = [
            'conf_name.required' => '配置项名称不能为空！',
            'conf_title.required' => '配置项标题不能为空！',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $result = Config::create($input);
            if ($result) {
                $this->putFile();
                return redirect('admin/config');
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
        $config = Config::find($id);

        return view('admin.config.edit', compact('config'));
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
        $result = Config::where('conf_id', $id)->update($input);

        if ($result) {
            $this->putFile();
            return redirect('admin/config');
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
        $result = Config::where('conf_id', $id)->delete();
        if ($result) {
            $this->putFile();
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

    public function changeContent(Request $request)
    {
        $input = $request->except('_token');
        foreach ($input['conf_id'] as $k => $v) {
            Config::where('conf_id', $v)->update(['conf_content' => $input['conf_content'][$k]]);
        }
        $this->putFile();

        return back()->with('errors', '配置项更新成功！');
    }

    public function putFile()
    {
        $configs = Config::pluck('conf_content', 'conf_name')->all();

        $path = base_path() . '/config/web.php';
        $str = '<?php return ' . var_export($configs, true) . ';';
        file_put_contents($path, $str);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $category = Config::find($input['conf_id']);
        $category->conf_order = $input['conf_order'];
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
