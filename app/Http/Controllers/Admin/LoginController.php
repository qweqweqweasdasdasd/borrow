<?php

namespace App\Http\Controllers\Admin;

use App\Manager;
use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\ManagerLoginRequest;

class LoginController extends Controller
{
    /**
     *	显示登录页面
     */
    public function login()
    {
    	if(Auth::guard('admin')->check()){
    		return redirect()->route('admin.index');
    	}
    	return view('admin.login.login');
    }

    /**
     *	登录动作
     */
    public function doLogin(ManagerLoginRequest $request)
    {
    	// Auth认证
    	$mgNamePasswd = $request->only(['mg_name','password']);
    	if(!Auth::guard('admin')->attempt($mgNamePasswd)){
    		return JsonResponse::JsonData(ApiErrDesc::MANAGER_AUTH_ERR[0],ApiErrDesc::MANAGER_AUTH_ERR[1]);
    	}

    	// 管理员状态判断		建议中间件
    	$manager = Auth::guard('admin')->user();
    	if($manager->mg_status != Manager::MANAGER_NORMAL){
    		return JsonResponse::JsonData(ApiErrDesc::MANAGER_BAN[0],ApiErrDesc::MANAGER_BAN[1]);
    	}

    	// 谷歌二次验证


    	// 记录登录时间,ip,次数
    	$manager->last_login_time = time();
    	$manager->ip = ip2long($request->getClientIp());
    	$manager->login_count = ++$manager->login_count;
    	$manager->save();

    	// 返回管理首页
    	$data = [
    		'url' => route('admin.index')
    	];
    	return JsonResponse::ResponseSuccess($data);
    }

    /**
     *  登出动作
     */
    public function logout()
    {
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
            return redirect()->route('login');
        }
        return redirect()->route('login');
    }

    /**
     *	获取到session_id
     */
    public function get()
    {
    	$keys = Redis::keys('*');
    	$data = Redis::get('_cache:HGFwtlwXWqNcq11IJxa6vMIbIcW60UiKV60nWDw3');
    	dump(json_decode( json_encode($data) ));
    	dump($keys);
    }
}
