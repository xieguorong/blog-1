@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin.info') }}">首页</a> &raquo; 自定义导航管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>自定义导航列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/nav/create') }}"><i class="fa fa-plus"></i>新增自定义导航</a>
                    <a href="{{ url('admin/nav') }}"><i class="fa fa-refresh"></i>全部导航</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>导航名称</th>
                        <th>导航j</th>
                        <th>导航地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($navs as $nav)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" value="{{ $nav->nav_order }}" onchange="changeOrder(this, {{ $nav->link_id }})">
                            </td>
                            <td class="tc">{{ $nav['nav_id'] }}</td>
                            <td>
                                <a href="#">{{ $nav['nav_name'] }}</a>
                            </td>
                            <td>{{ $nav['nav_alias'] }}</td>
                            <td>{{ $nav['nav_url'] }}</td>
                            <td>
                                <a href="{{ url('admin/nav/' . $nav->nav_id . '/edit') }}">修改</a>
                                <a href="javascript:void(0);" onclick="delLink({{ $nav->nav_id }})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{ $navs->links() }}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>
    <script>
        $(function () {
        });

        function changeOrder (obj, nav_id) {
            var nav_order = $(obj).val();
            $.post('{{ url('admin/links/changeorder') }}', {'_token': '{{ csrf_token() }}', nav_id: nav_id, nav_order: nav_order}, function (data) {
                if (data.status == 0) {
                    layer.msg(data.msg, {icon: 6});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }

        function delLink(nav_id) {
            layer.confirm('你确定删除这个自定义导航吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post("{{ url('admin/links') }}/" + nav_id, {_token: "{{ csrf_token() }}", _method: "delete"}, function (data) {
                    if (data.status == 0) {
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            });
        }
    </script>
@endsection
