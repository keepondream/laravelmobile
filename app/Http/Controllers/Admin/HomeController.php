<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Access;
use App\http\Model\AdminUser;
use App\http\Model\Menu;
use App\http\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * 后台首页
     */
    public function index()
    {
        //查询导航栏菜单
        $data['count'] = Menu::count();
        $data['category'] = Common::tree();
        //此处图标未集成,以后集成
//        $data['icon'] = [
//            '&#xe62d;',//管理员
//            '&#xe60d;',//会员
//            '&#xe620;',//产品
//            '&#xe613;',//图片
//            '&#xe616;',//资讯
//            '&#xe622;',//评论
//        ];
        return view('admin/index',$data);
    }

    /**
     * 子首页 我的桌面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('admin/welcome');
    }

    /**
     * 初始化数据
     */
    public function assist(Request $request)
    {
        $outData = [];
        //填充后台超级管理员
        if (empty(AdminUser::all()->toArray())) {
            $res['name'] = 'fanleguan';//管理员名称
            $res['password'] = md5(md5('pk'.'fanleguan'));//管理员密码
            if (AdminUser::create($res)) {
                $outData[] = '管理员初始化成功!~';
            } else {
                $outData[] = '管理员初始化失败!~';
            }
        } else {
            $outData[] = '管理员表有数据不能初始化!~';
        }
        //填充菜单
        if (empty(Menu::all()->toArray())) {
            $res = [];
            $res[] = [
                'name' => '管理员管理',
                'url' => '',
                'icon' => '&#xe62d;',
                'parent_id' => '0',
                'list' => [
                 ['name'=>'权限管理','url'=>'access'],
                 ['name'=>'角色管理','url'=>'role'],
                 ['name'=>'管理员列表','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '会员管理',
                'url' => '',
                'icon' => '&#xe60d;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'会员列表','url'=>''],
                    ['name'=>'删除的会员','url'=>''],
                    ['name'=>'等级管理','url'=>''],
                    ['name'=>'积分管理','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '产品管理',
                'url' => '',
                'icon' => '&#xe620;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'品牌管理','url'=>''],
                    ['name'=>'分类管理','url'=>''],
                    ['name'=>'产品列表','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '订单管理',
                'url' => '',
                'icon' => '&#xe616;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'订单列表','url'=>''],
                    ['name'=>'未支付订单','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '日志管理',
                'url' => '',
                'icon' => '&#xe61a;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'会员登录日志','url'=>''],
                    ['name'=>'会员操作记录','url'=>''],
                ],
            ];

            foreach ($res as $k => $data) {
                $tempArr = $data['list'];
                unset($data['list']);
                $data['sort'] = (string)(51 + $k);
                $id = Menu::create($data)->id;
                if ($id > 0) {
                    if (count($tempArr) > 0) {
                        $outData[] = $data['name'].' - 初始化成功!~';
                        foreach ($tempArr as $k1 => $v) {
                            $v['parent_id'] = $id;
                            $v['sort'] = (string)(101 + $k1);
                            if (Menu::create($v)) {
                                $outData[] = $v['name'].' - 初始化成功!~';
                            } else {
                                $outData[] = $v['name'].' --------------初始化----失败!~';
                            }
                        }
                    }
                } else {
                    $outData[] = $data['name'].' --------------初始化----失败!~';
                }
            }
        } else {
            $outData[] = '菜单表有数据不能初始化!~';
        }
        //初始化权限
        if (empty(Access::all()->toArray())) {
            $res = [];
            # 系统
            $res[] = [
                'title' => '系统管理',
                'url' => 'systemIndex'
            ];
            $res[] = [
                'title' => '系统设置',
                'url' => 'systemSet'
            ];
            $res[] = [
                'title' => '菜单管理',
                'url' => 'menuIndex'
            ];
            $res[] = [
                'title' => '菜单管理查看',
                'url' => 'menu'
            ];
            $res[] = [
                'title' => '菜单管理添加',
                'url' => 'menuAdd'
            ];
            $res[] = [
                'title' => '菜单管理删除',
                'url' => 'menuDel'
            ];

            # 管理员
            $res[] = [
                'title' => '管理员管理',
                'url' => 'managerIndex'
            ];
            $res[] = [
                'title' => '权限管理查看',
                'url' => 'access'
            ];
            $res[] = [
                'title' => '权限管理添加',
                'url' => 'accessAdd'
            ];
            $res[] = [
                'title' => '权限管理删除',
                'url' => 'accessDel'
            ];
            $res[] = [
                'title' => '角色管理查看',
                'url' => 'role'
            ];
            $res[] = [
                'title' => '角色管理添加',
                'url' => 'roleAdd'
            ];
            $res[] = [
                'title' => '角色管理删除',
                'url' => 'roleDel'
            ];
            $res[] = [
                'title' => '管理员列表查看',
                'url' => 'manager'
            ];
            $res[] = [
                'title' => '管理员列表添加',
                'url' => 'managerAdd'
            ];
            $res[] = [
                'title' => '管理员列表删除',
                'url' => 'managerDel'
            ];

            # 会员
            $res[] = [
                'title' => '会员管理',
                'url' => 'memberIndex'
            ];
            $res[] = [
                'title' => '会员列表查看',
                'url' => 'member'
            ];
            $res[] = [
                'title' => '会员添加',
                'url' => 'memberAdd'
            ];
            $res[] = [
                'title' => '会员删除',
                'url' => 'memberDel'
            ];
            $res[] = [
                'title' => '删除会员列表查看',
                'url' => 'memberDelIndex'
            ];
            $res[] = [
                'title' => '删除会员列表永久删除',
                'url' => 'memberDelOver'
            ];
            $res[] = [
                'title' => '等级管理查看',
                'url' => 'rank'
            ];
            $res[] = [
                'title' => '等级管理操作',
                'url' => 'rankAction'
            ];
            $res[] = [
                'title' => '积分管理查看',
                'url' => 'credit'
            ];
            $res[] = [
                'title' => '积分管理操作',
                'url' => 'creditAction'
            ];

            foreach ($res as $k => $v) {
                if (Access::create($v)) {
                    $outData[] = $v['title'].' - 初始化成功!~';
                } else {
                    $outData[] = $v['title'].' --------------初始化----失败!~';
                }
            }
        } else {
            $outData[] = '权限表有数据不能初始化!~';
        }
        return response()->json(Common::jsonOutData(200,'ok',$outData));
    }
}
