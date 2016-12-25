<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    //图片上传
    public function upload(Request $request)
    {
        $file = $request->file('Filedata');
        if ($file->isValid()) {
            $realPath = $file->getRealPath(); //临时文件的绝对路径
            $extension = $file->getClientOriginalExtension(); //临时文件的扩展名
            $newName = date('YmdHis') .mt_rand(100, 999) . '.' . $extension;
            $path = $file->move('uploads/', $newName);
            $filePath = 'uploads/' . $newName;

            return $filePath;
        }
    }
}
