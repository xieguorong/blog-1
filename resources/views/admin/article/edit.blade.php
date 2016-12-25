@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a>  &raquo; 文章编辑
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>编辑文章</h3>
            @if(count($errors) > 0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    @else
                        <p>{{ $errors }}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/article/create') }}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="{{ url('admin/article') }}"><i class="fa fa-refresh"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{ url('admin/article/' . $article->art_id) }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120">分类：</th>
                    <td>
                        <select name="cate_id">
                            <option value="0">==顶级分类==</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->cate_id }}"
                                    @if($category->cate_id == $article->cate_id)
                                        selected
                                    @endif
                                >{{ $category->cate_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title" value="{{ $article->art_title }}">
                    </td>
                </tr>
                <tr>
                    <th>编辑：</th>
                    <td>
                        <input type="text" class="sm" name="art_editor" value="{{ $article->art_editor }}">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" size="50" class="lg" name="art_thumb" value="{{ $article->art_thumb }}" readonly>
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <img src="/{{ $article->art_thumb }}" alt="" id="art_thumb_img" style="max-height: 350px; max-width: 100px;">
                    </td>
                </tr>
                <tr>
                    <th>关键词：</th>
                    <td>
                        <input type="text" class="lg" name="art_tag" value="{{ $article->art_tag }}">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="art_description">{{ $article->art_description }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>文章内容：</th>
                    <td width="1000px">
                        <!-- 加载编辑器的容器 -->
                        <script id="container" name="art_content" type="text/plain">{!! $article->art_content !!}</script>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('uploadify/uploadify.css') }}">
    <style>
        .edui-default { line-height: 28px; }
        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body{ overflow: hidden; height: 20px; }
        div.edui-box { overflow: hidden; height: 22px; }

        /** uploadify **/
        .uploadify{ display: inline-block;  }
        .uploadify-button{ border: none; border-radius: 5px; margin-top: 8px;  }
        table.add_tab tr td span {color: #FFF; margin:0;}
    </style>

    <script src="{{ asset('uploadify/jquery.uploadify.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadify({
                'buttonText': '图片上传',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{ csrf_token() }}"
                },
                'swf'      : "{{ asset('uploadify/uploadify.swf') }}",
                'uploader' : "{{ url('admin/upload') }}",
                'onUploadSuccess' : function(file, data, response) {
                    $('input[name=art_thumb]').val(data);
                    $('#art_thumb_img').attr('src', '/' + data);
                }
            });
        });
    </script>

    <!-- 配置文件 -->
    <script type="text/javascript" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{ asset('ueditor/ueditor.all.js') }}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
@endsection
