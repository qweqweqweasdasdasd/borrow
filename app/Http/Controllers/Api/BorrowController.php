<?php

namespace App\Http\Controllers\Api;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Borrow\KKbet;

class BorrowController extends Controller
{
    /**
     *	获取到用户信息
     */
    public function getUserInfo()
    {
    	$data = [
    		'username' => 'akai999'
    	];
    	try {
    		$user = (new KKbet)->getUserInfo($data);
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    	dump($user);
    }

    /**
     *	添加分数
     */
    public function addPoint()
    {
    	$data = [
    		'balance' => 1,
    		'username' => 'akai999',
    	];

    	try {
    		$res = (new KKbet)->addPoint($data);
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    	dump($res);
    }

    /**
     *	扣除分数
     */
    public function subtractPoint()
    {
    	$data = [
    		'balance' => 1,
    		'username' => 'akai999',
    	];

    	try {
    		$res = (new KKbet)->subtractPoint($data);
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    	dump($res);
    }

    /**
     *	心跳包
     */
    public function heartbeat()
    {
    	$res = (new KKbet)->heartbeat();
    	if($res){
           return JsonResponse::ResponseSuccess(['status'=>$res]);
        }
	    return JsonResponse::ResponseSuccess(['status'=>$res]);

    }

}
