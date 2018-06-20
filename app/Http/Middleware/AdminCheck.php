<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检测网站cookie是否存在
        if (empty($request->cookie('adminKey'))) {
            //5分钟没有操作需要重新登录
            return redirect('admin/login');
        } else {
            //否则自动更新时间 重新给5分钟时间
            Cookie::queue('adminKey',$request->cookie('adminKey'),50);
        }
        return $next($request);
    }
}
