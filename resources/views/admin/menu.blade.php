@extends('layouts.adminchild')
@section('title','菜单管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        系统管理
        <span class="c-gray en">&gt;</span>
        菜单管理
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{route('menu')}}" method="post" class="form form-horizontal" id="form-category-add">
                @csrf
                <div>
                    <div style="margin:auto;position: relative;width: 520px;">
                        <input type="text" name="searchData" id="searchData" placeholder="栏目名称、id" style="width:250px" class="input-text">
                        <button name="" id="" class="btn btn-success" type="submit" ><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
		<a class="btn btn-primary radius" onclick="system_category_add('添加菜单','{{route('menuAdd')}}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加菜单</a>
		</span>
            <span class="r">共有数据：<strong>{{!empty($count) ? $count : 0}}</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="80">排序</th>
                    <th>栏目名称</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $k => $v)
                        <tr class="text-c">
                            <td><input type="checkbox" name="id" value="{{$v['id']}}"></td>
                            <td>{{$v['id']}}</td>
                            <td>{{$v['sort']}}</td>
                            @if(empty($v['count']))
                                <td class="text-l">{{$v['name']}}</td>
                            @else
                                <td class="text-l">&nbsp;&nbsp;├&nbsp;{{$v['name']}}</td>
                            @endif
                            <td class="f-14"><a title="编辑" href="javascript:;" onclick="system_category_edit('菜单编辑','{{route('menuAdd',['id'=>$v['id']])}}','{{$v['id']}}','700','480')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a title="删除" href="javascript:;" onclick="system_category_del(this,'{{$v['id']}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </tr>
                    @endforeach
                @endif

                {{--<tr class="text-c">--}}
                    {{--<td><input type="checkbox" name="" value=""></td>--}}
                    {{--<td>2</td>--}}
                    {{--<td>2</td>--}}
                    {{--<td class="text-l">&nbsp;&nbsp;├&nbsp;二级栏目</td>--}}
                    {{--<td class="f-14"><a title="编辑" href="javascript:;" onclick="system_category_edit('栏目编辑','system-category-add.html','2','700','480')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>--}}
                        {{--<a title="删除" href="javascript:;" onclick="system_category_del(this,'2')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>--}}
                {{--</tr>--}}
                {{--<tr class="text-c">--}}
                    {{--<td><input type="checkbox" name="" value=""></td>--}}
                    {{--<td>3</td>--}}
                    {{--<td>3</td>--}}
                    {{--<td class="text-l">&nbsp;&nbsp;├&nbsp;二级栏目</td>--}}
                    {{--<td class="f-14"><a title="编辑" href="javascript:;" onclick="system_category_edit('栏目编辑','system-category-add.html','3','700','480')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>--}}
                        {{--<a title="删除" href="javascript:;" onclick="system_category_del(this,'3')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>--}}
                {{--</tr>--}}
                </tbody>

            </table>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/datatables/1.10.0/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/laypage/1.2/laypage.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        var _token = $("meta[name='csrf-token']").attr('content');
        $('.table-sort').dataTable({
            "aaSorting": [[ 0, "asc" ]],//默认第几个排序
            "bStateSave": false,//状态保存
            "aoColumnDefs": [
                // {"bVisible": false, "aTargets": [ 1 ]}, //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,4]}// 制定列不参与排序
            ]
        });
        /*系统-栏目-添加*/
        function system_category_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*系统-栏目-编辑*/
        function system_category_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*系统-栏目-删除*/
        function system_category_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('menuDel')}}',
                    data:{id:id,_token:_token},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").remove();
                            layer.msg(data.msg,{icon:1,time:1000});
                        } else {
                            layer.msg(data.msg,{icon:5,time:1000});
                        }
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*批量删除*/
        function datadel() {
            var ids = [];
            $('input[name="id"]:checked').each(function (j) {
                if (j >= 0) {
                    ids.push($(this).val());
                }
            });
            if (ids.length > 0) {
                layer.confirm('确认要删除吗？',function(index) {
                    $.ajax({
                        type:'post',
                        url:'{{route('menuDel')}}',
                        data:{ids:ids,_token:_token},
                        dataType:'json',
                        success:function (data) {
                            if (data.code == 200) {
                                window.location.reload();
                            } else {
                                layer.msg(data.msg,{icon:5,time:1000})
                            }
                        }
                    });
                });
            } else {
                layer.msg('请先选择再删除!~',{icon:5,time:1000})
            }
        }

        $("#form-category-add").validate({
            rules:{
                searchData:"required",
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                return true;
                // $(form).ajaxSubmit(function (data) {
                //     if (data.code != 200) {
                //         layer.msg(data.msg,{icon:2,time:1000})
                //     } else {
                //         layer.msg(data.msg,{icon:1,time:1000})
                //     }
                // });
                // setTimeout(function () {
                //     var index = parent.layer.getFrameIndex(window.name);
                //     // parent.$('.btn-refresh').click();
                //     parent.window.location.reload();
                //     parent.layer.close(index);
                // },1000);

            }
        });
    </script>
@endsection

