@extends('layouts.adminchild')
@section('title','添加菜单')
@section('content')
    <div class="page-container">
        <form action="{{route('menuAdd')}}" method="post" class="form form-horizontal" id="form-category-add">
            @csrf
            <input type="hidden" name="id" value="{{!empty($_GET['id']) ? $_GET['id'] : ''}}">
            <div id="tab-category" class="HuiTab">
                <div class="tabBar cl">
                    <span>基本设置</span>
                    {{--<span>模版设置</span>--}}
                    <span>SEO</span>
                </div>
                <div class="tabCon">
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">栏目ID：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">11230</div>--}}
                    {{--</div>--}}
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">
                            <span class="c-red">*</span>
                            上级栏目：</label>
                        <div class="formControls col-xs-8 col-sm-9">
						<span class="select-box">
						<select class="select" id="sel_Sub" name="parent_id">
							<option value="0">顶级栏目</option>
                            @if(!empty($category))
                                @foreach($category as $k => $v)
                                    @if(!empty($data) && ($v['id'] == $data['parent_id']))
                                        <option value="{{$v['id']}}" selected="selected">{{$v['name']}}</option>
                                    @else
                                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                                    @endif
                                    @if(isset($v['list']) && !empty($v['list']))
                                        @foreach($v['list'] as $k1 => $v1)
                                                @if(!empty($data) && ($v1['id'] == $data['parent_id']))
                                                    <option value="{{$v1['id']}}" selected="selected">{{$v['name']}}</option>
                                                @else
                                                    <option value="{{$v1['id']}}" disabled>&nbsp;&nbsp;├ {{$v1['name']}}</option>
                                                @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
						</select>
						</span>
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">
                            <span class="c-red">*</span>
                            栏目名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{!empty($data) ? $data['name'] : ''}}" placeholder="请输入菜单栏名称" id="name" name="name">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">
                            <span class="c-red">*</span>
                            路&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;劲：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{!empty($data) ? $data['url'] : ''}}" placeholder="请输入路劲名称 如:系统设置 set" id="url" name="url">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">
                            <span class="c-red">*</span>
                            排&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;序：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{!empty($data) ? $data['sort'] : '50'}}" placeholder="默认:50" id="sort" name="sort">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">别名：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input type="text" class="input-text" value="" placeholder="" id="" name="">--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">路径：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input type="text" class="input-text" value="" placeholder="请输入路劲名称 如:系统设置 set" id="url" name="url">--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">内容类型：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
						{{--<span class="select-box">--}}
						{{--<select name="" class="select">--}}
							{{--<option value="1">文章</option>--}}
							{{--<option value="2">图片</option>--}}
							{{--<option value="3">商品</option>--}}
							{{--<option value="4">视频</option>--}}
							{{--<option value="5">专题</option>--}}
							{{--<option value="6">链接</option>--}}
						{{--</select>--}}
						{{--</span>--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">是否生成静态html：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9 skin-minimal">--}}
                            {{--<div class="check-box">--}}
                                {{--<input type="checkbox" id="checkbox-pinglun">--}}
                                {{--<label for="checkbox-pinglun">&nbsp;</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                {{--<div class="tabCon">--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">首页模版：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input type="text" class="input-text" value="" style="width:200px;">--}}
                            {{--<input type="button" class="btn btn-default" value="浏览">--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">列表页模版：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input type="text" class="input-text" value="" style="width:200px;">--}}
                            {{--<input type="button" class="btn btn-default" value="浏览">--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">详情页模版：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input type="text" class="input-text" value="" style="width:200px;">--}}
                            {{--<input type="button" class="btn btn-default" value="浏览">--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">详细页存储规则：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
						{{--<span class="select-box">--}}
						{{--<select class="select" id="" name="">--}}
							{{--<option value="1">按年度划子目录</option>--}}
							{{--<option value="2">按年/月划分子目录</option>--}}
							{{--<option value="3">按年/月/日划分子目录</option>--}}
						{{--</select>--}}
						{{--</span>--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row cl">--}}
                        {{--<label class="form-label col-xs-4 col-sm-3">每页显示多少条：</label>--}}
                        {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input type="text" class="input-text" value="20" style="width:200px;">--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">首页文件名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="index.html" style="width:200px;">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">关键词：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="">
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">描述：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,100)"></textarea>
                            <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
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
                    name:"required",
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

