<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JiekuanController extends Controller
{
    /**
     *	首页
     */
    public function index()
    {
    	return view('wap.jiekuan.index');
    }

    /** 
     *	提交表单
     */
    public function submit(Request $request)
    {
    	dd($request->all());
    }
}
