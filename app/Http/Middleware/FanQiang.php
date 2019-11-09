<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class FanQiang
{
    /**
     *  管理员对象
     */
    protected $manager;

    /**
     *  request 对象
     */
    protected $request;

    /**
     *  redis 前缀
     */
    protected $keyPre = '_cache:';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->request = $request;
        $this->manager = Auth::guard('admin')->user();

        $this->sso();
        $this->checkManagerHasPermission();
       
        return $next($request);
    }

    /**
     *  检查当前管理员是否有权限
     */
    public function checkManagerHasPermission()
    {
        // 非超级管理员
        if(!$this->manager->isRoot()){
            // 获取管理员权限列表
            $hasPermissionList = json_decode($this->manager->hasPermissionList(),true);
            
            $nowCA = strtolower(getCurrentControllerName().'-'.getCurrentMethodName());
            // 判断当前控制器和方法是否在权限列表内
            // dump($nowCA);
            // dump($hasPermissionList);
            if(!in_array($nowCA, $hasPermissionList)){
                exit('无权限!');
            }
        };
        return true;
    }

    /**
     *  sso 不同游览器只允许登录一个管理员
     */
    public function sso()
    {
        $sessionId = $this->request->session()->getId();
        $session_id = $this->manager->session_id;

        //  数据库 session_id 存在 && 数据库和来源不一致
        if(!empty($session_id) && $sessionId != $session_id){
            Redis::set($this->keyPre.$session_id,'');
        }

        $this->manager->session_id = $sessionId;
        $this->manager->save();
    }
}
