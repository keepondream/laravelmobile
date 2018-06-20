@extends('layouts.adminchild')
@section('title','添加权限')
@section('content')
    <div class="page-container">
        <form action="{{route('accessAdd')}}" method="post" class="form form-horizontal" id="form-category-add">
            @csrf
            <input type="hidden" name="id" value="{{!empty($_GET['id']) ? $_GET['id'] : ''}}">
            <div id="tab-category" class="HuiTab">
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">
                            <span class="c-red">*</span>
                            权限名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{!empty($data) ? $data['title'] : ''}}" placeholder="请输入控制菜单或操作名称" id="title" name="title">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">
                            <span class="c-red">*</span>
                            字段名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{!empty($data) ? $data['url'] : ''}}" placeholder="请输入控制权限字段名" id="url" name="url">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-9 col-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#tab-category").Huitab({
                index:0
            });
            $("#form-category-add").validate({
                rules:{
                    title:"required",
                    url:"required",
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit(function (data) {
                        if (data.code != 200) {
                            layer.msg(data.msg,{icon:2,time:1000})
                        } else {
                            layer.msg(data.msg,{icon:1,time:1000})
                        }
                    });
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        // parent.$('.btn-refresh').click();
                        parent.window.location.reload();
                        parent.layer.close(index);
                    },1000);

                }
            });
        });
    </script>
@endsection

