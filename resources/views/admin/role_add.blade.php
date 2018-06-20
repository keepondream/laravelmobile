@extends('layouts.adminchild')
@section('title','添加角色')
@section('content')
    <article class="page-container">
        <form action="{{route('roleAdd')}}" method="post" class="form form-horizontal" id="form-admin-role-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="请输入角色名称" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="请输入角色描述" id="" name="desc">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">网站角色：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <dl class="permission-list">
                        <dd>
                            <dl class="cl permission-list2">
                                <dd style="margin: auto;">
                                    @if(!empty($accesses))
                                        @foreach($accesses as $v)
                                            <div style="width: 25%;float: left;">
                                                <label class="">
                                                    <input type="checkbox" value="{{$v['id']}}" name="accessid[]">
                                                    {{$v['title']}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </dd>
                            </dl>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-success radius" id="admin-role-save" ><i class="icon-ok"></i> 确定</button>
                </div>
            </div>
        </form>
    </article>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            // $(".permission-list dt input:checkbox").click(function(){
            //     $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
            // });
            // $(".permission-list2 dd input:checkbox").click(function(){
            //     var l =$(this).parent().parent().find("input:checked").length;
            //     var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
            //     if($(this).prop("checked")){
            //         $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
            //         $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
            //     }
            //     else{
            //         if(l==0){
            //             $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
            //         }
            //         if(l2==0){
            //             $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
            //         }
            //     }
            // });

            $("#form-admin-role-add").validate({
                rules:{
                    name:{
                        required:true,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit();
                    // var index = parent.layer.getFrameIndex(window.name);
                    // parent.layer.close(index);
                }
            });
        });
    </script>
@endsection

