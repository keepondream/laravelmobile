<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Access;
use App\http\Model\Menu;
use App\http\Model\Role;
use App\http\Model\RoleAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MangerController extends Controller
{
    //管理员管理
    /**
     * 角色管理
     * @param Request $request
     */
    public function role(Request $request)
    {
        return view('admin/role');
    }

    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleAdd(Request $request)
    {
        //获取所有权限 便于添加角色时进行权限划分
        $data['accesses'] = Access::all()->toArray();

        $param = Common::dataCheck($request->input());
        $data['data'] = '';
        $param = [];
        $param['id'] = 3;
        $param['name'] = '我来修改';
        $param['desc'] = '修改了';
        $param['accessid'] = [];
        if (!empty($param['id'])) {
            //获取当前用户的信息 和所有权限ID
            $role = Role::find($param['id']);
            if (!empty($role)) {
                $data['data'] = $role->toArray();
                $accessids = RoleAccess::where('role_id',$param['id'])->get(['access_id'])->toArray();
                $data['accessids'] = array_column($accessids,'access_id');
            }
        }
        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if($request->isMethod('post')){
            if (!empty($role)) {
                //修改
                $role->name = $param['name'];
                $role->desc = $param['desc'];
                if ($role->save()) {
                    if (!empty($param['accessid'])) {
                        //循环比较修改的数据
                        foreach ($param['accessid'] as $v) {
                            if (!empty($data['accessids']) && in_array($v,$data['accessids'])) {
                                //如果当前的id在原先的数组中 进行比对删除数组 筛选不在其中的
                                foreach ($data['accessids'] as $k => $vs) {
                                    if ($vs == $v) {
                                        unset($data['accessids'][$k]);
                                        continue;
                                    }
                                }
                            } else {
                                //进行新增操作
                                $tempData = [];
                                $tempData['role_id'] = $param['id'];
                                $tempData['access_id'] = $v;
                                RoleAccess::create($tempData);
                            }
                        }
                    }
                    //如果还有旧的值 则进行旧数据删除
                    if (!empty($data['accessids'])) {
                        RoleAccess::whereIn('access_id',$data['accessids'])->delete();
                    }
                    $msg = Common::jsonOutData(200,'编辑成功!');
                }
            } else {
                //新增
                unset($param['id']);
                $accessid = $param['accessid'];
                unset($param['accessid']);
                $newRoleId = Role::create($param)->id;
                if (count($accessid) > 0) {
                    foreach ($accessid as $v) {
                        $tempData = [];
                        $tempData['role_id'] = $newRoleId;
                        $tempData['access_id'] = $v;
                        RoleAccess::create($tempData);
                    }
                }
                $msg = Common::jsonOutData(200,'添加成功!');
            }
            return response()->json($msg);
        }


        return view('admin/role_add',$data);
    }

    /**
     * 删除角色
     * @param Request $request
     */
    public function roleDel(Request $request)
    {

    }

    /**
     * 权限管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function access(Request $request)
    {
        $param = Common::dataCheck($request->input());
        //获取相关数据
        $data['count'] = Access::count();
        $data['data'] = Access::all()->toArray();

        //判断是否有搜索
        if (!empty($param) && isset($param['searchData']) && $request->isMethod('post')) {
            $idOrname = $param['searchData'];
            if (!empty($idOrname)) {
                $res = Access::where(function ($query) use ($idOrname) {
                    $query->where('id',$idOrname)
                        ->orWhere('title','like','%'.$idOrname.'%');
                })->get();
                if (count($res) > 0) {
                    $data['data'] = $res->toArray();
                }
            }
        }
        return view('admin/access',$data);
    }

    /**
     * 添加权限
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accessAdd(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $data['data'] = '';
        if (!empty($param['id'])) {
            $access = Access::find($param['id']);
            if (!empty($access)) {
                $data['data'] = $access->toArray();
            }
        }
        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if($request->isMethod('post')){
            if (!empty($access)) {
                //修改
                $access->title = $param['title'];
                $access->url = $param['url'];
                $msg = Common::jsonOutData(201,'编辑失败!~');
                if ($access->save()) {
                    $msg = Common::jsonOutData(200,'编辑成功!');
                }
            } else {
                //新增
                unset($param['id']);
                $res = Access::create($param);
                $msg = Common::jsonOutData(201,'添加失败!~');
                if ($res) {
                    $msg = Common::jsonOutData(200,'添加成功!');
                }
            }
            return response()->json($msg);
        }
        return view('admin/access_add',$data);
    }

    /**
     * 删除权限
     * @param Request $request
     */
    public function accessDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'删除失败!~');
        if (!empty($request->isMethod('post'))) {
            if (!empty($param['id'])) {
                $res = Access::destroy($param['id']);
            } elseif (!empty($param['ids'])) {
                $res = Access::destroy($param['ids']);
            }
            if ($res) {
                $msg = Common::jsonOutData(200,'删除成功!');
            }
        }
        return response()->json($msg);
    }




}
