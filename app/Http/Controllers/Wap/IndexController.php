<?php

namespace App\Http\Controllers\Wap;

use DB;
use App\Member;
use App\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     *  首页跳转goto
     */
    public function goto()
    {
        return redirect('/index');
    }

    /**
     *	我要还款
     */
    public function hk(Request $request)
    {
    	$route = $request->path();
        $webset = \DB::table('webset')->first();
    	return view('wap.index.hk',compact('route','webset'));
    }

    /**
     *	信用规则查询
     */
    public function index(Request $request)
    {
    	$route = $request->path();
        $webset = DB::table('webset')->first();
        //dump($webset);
    	return view('wap.index.index',compact('route','webset'));
    }

    /**
     *  sousou
     */
    public function sousou()
    {
        return ['ok'=>true];
    }

    /** 
     *  alert
     */
    public function alert(Request $request)
    {
        error_reporting(0);
        $userAccount = $request->get('userAccount');
        $bills =Bill::where('userAccount',$userAccount)->orderBy('b_id','desc')->take(10)->get();
        $member = Member::with(['vip','pandect'])->where('userAccount',$userAccount)->first();
        //dump($bills);

        return view('wap.index.alert',compact('bills','member'));
    }
}
