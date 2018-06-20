<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    //系统管理
    
    //系统设置
    public function set()
    {
        return view('admin/set');
    }

    /**
     * 菜单栏目管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu(Request $request)
    {
        $param = Common::dataCheck($request->input());

        //获取当前的菜单栏
        $data['count'] = Menu::count();
        $content = Menu::all()->toArray();
        if (!empty($content)) {
            $data['data'] = Common::getTree($content);
        }
        //判断是否有搜索
        if (!empty($param) && isset($param['searchData']) && $request->isMethod('post')) {
            $idOrname = $param['searchData'];
            if (!empty($idOrname)) {
                $res = Menu::where(function ($query) use ($idOrname) {
                    $query->where('id',$idOrname)
                        ->orWhere('name','like','%'.$idOrname.'%');
                })->get();
                if (count($res) > 0) {
                    $data['data'] = $res->toArray();
                }
            }
        }
        return view('admin/menu',$data);
    }

    /**
     * 添加菜单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function menuAdd(Request $request)
    {
        //获取数据并验证安全处理
        $param = Common::dataCheck($request->input());
        $data['data'] = '';
        if (!empty($param['id'])) {
            $menu = Menu::find($param['id']);
            if (!empty($menu)) {
                $data['data'] = $menu->toArray();
            }
        }
        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if($request->isMethod('post')){
            if (!empty($menu)) {
                //修改
                $menu->name = $param['name'];
                $menu->url = $param['url'];
                $menu->parent_id = $param['parent_id'];
                !empty($param['sort']) && $menu->sort = $param['sort'];
                $msg = Common::jsonOutData(201,'编辑失败!~');
                if ($menu->save()) {
                    $msg = Common::jsonOutData(200,'编辑成功!');
                }
            } else {
                //新增
                unset($param['id']);
                $res = Menu::create($param);
                $msg = Common::jsonOutData(201,'添加失败!~');
                if ($res) {
                    $msg = Common::jsonOutData(200,'添加成功!');
                }
            }
            return response()->json($msg);
        }
        $data['category'] = Common::tree();

        return view('admin/menu_add',$data);
    }

    /**
     * 删除菜单
     * @param Request $request
     */
    public function menuDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'删除失败!~');
        if (!empty($request->isMethod('post'))) {
            if (!empty($param['id'])) {
                //验证一级菜单是否有子菜单 有则不能删除
                $checkModel = Menu::where('parent_id',$param['id'])->get()->toArray();
                if (!empty($checkModel)) {
                    $msg = Common::jsonOutData(201,'请先删除子菜单后再删除主菜单!~');
                    $res = '';
                } else {
                    $res = Menu::destroy($param['id']);
                }
            } elseif (!empty($param['ids'])) {
                $checkModel = Menu::whereIn('parent_id',$param['ids'])->get()->toArray();
                if (!empty($checkModel)) {
                    $msg = Common::jsonOutData(201,'请先删除子菜单后再删除主菜单!~');
                    $res = '';
                } else {
                    $res = Menu::destroy($param['ids']);
                }
            }
            if ($res) {
                $msg = Common::jsonOutData(200,'删除成功!');
            }
        }
        return response()->json($msg);
    }
}
