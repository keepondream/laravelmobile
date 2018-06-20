<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /**
     * 登录首页
     */
    public function index()
    {
        return view('admin/login');
    }

    /**
     * 登录
     */
    public function login(Request $request)
    {
        //过滤获取参数
        $param = Common::dataCheck($request->input(),false);
        //获取系统token
        $token = $request->session()->token();
        //验证参数及防治csrf攻击
        if (!empty($param['name']) && !empty($param['password']) && ($param['_token'] == $token)) {
            $password = md5(md5('pk'.$param['password']));
            $adminUser = AdminUser::where('name',$param['name'])->get()->toArray();
            if (!empty($adminUser)) {
                if ($adminUser[0]['password'] == $password) {
                    Cookie::queue('adminKey',$adminUser[0]['id'],5);//默认5分钟无操作 需要登录
                    return redirect('admin');
                }
            }
        }
        return redirect('admin/login');
    }

    /**
     * 退出后台登陆
     * @param Request $request
     */
    public function loginOut(Request $request)
    {
        $cookie = Cookie::forget('adminKey');
        return Redirect('admin/login')->withCookie($cookie);
    }
}
