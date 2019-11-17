<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsetController extends Controller
{
    /**
     *	网站设置
     */
    public function show($id)
    {
    	$webset = DB::table('webset')->first();
    	//dump($webset);	
    	return view('admin.webset.show',compact('webset'));
    }

    /**
     *	更新数据
     */
    public function update(Request $request,$id)
    {
    	$data = DB::table('webset')->where('w_id',1)->update($request->all());
    	if(!$data){
            return JsonResponse::JsonData(ApiErrDesc::CREDIT_UPDATE_FAIL[0],ApiErrDesc::CREDIT_UPDATE_FAIL[1]);
        };
        return JsonResponse::ResponseSuccess();
    }
}
