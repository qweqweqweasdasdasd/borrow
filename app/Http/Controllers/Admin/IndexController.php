<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     *	管理后台首页
     */
    public function index()
    {
    	if(\Auth::guard('admin')->check()){
    		return view('admin.index.index');
    	}
    	return redirect()->route('login');
    }

    /**
     *  welcome 页面
     */
    public function welcome()
    {
        $manager = \Auth::guard('admin')->user();
        $manager->last_login_time = date('Y-m-d H:i:s',$manager->last_login_time);
        
        return view('admin.index.welcome',compact('manager'));
    }
}
