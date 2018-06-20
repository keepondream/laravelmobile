<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




//后台路由 中间件检测
Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {
    //辅助数据填充
    Route::get('assistInitOnlyOwn','HomeController@assist');

    //登录
    Route::get('login','LoginController@index');
    Route::post('login','LoginController@login')->name('adminlogin');
    Route::get('loginOut','LoginController@loginOut')->name('adminloginout');
    //首页
    Route::get('/', 'HomeController@index')->name('admin')->middleware('adminCheck');     //检测登录状态是否过期
    //我的桌面
    Route::get('welcome','HomeController@welcome')->name('Awelcome');
    //系统管理
    Route::get('set','SiteController@set')->name('set');
    //菜单管理
    Route::any('menu','SiteController@menu')->name('menu');
    Route::any('menuAdd','SiteController@menuAdd')->name('menuAdd');
    Route::post('menuDel','SiteController@menuDel')->name('menuDel');

    //管理员管理
    //角色
    Route::get('role','MangerController@role')->name('role');
    Route::any('roleAdd','MangerController@roleAdd')->name('roleAdd');
    Route::any('roleDel','MangerController@roleDel')->name('roleDel');
    //权限
    Route::any('access','MangerController@access')->name('access');
    Route::any('accessAdd','MangerController@accessAdd')->name('accessAdd');
    Route::post('accessDel','MangerController@accessDel')->name('accessDel');

    //会员管理


    //产品管理


    //订单管理
});

