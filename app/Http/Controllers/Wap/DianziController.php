<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CreditRepository;

class DianziController extends Controller
{
	/**
     *  账单仓库
     */
    protected $credit;

    /**
     *  初始化数据
     */
    public function __construct(CreditRepository $credit)
    {
        $this->credit = $credit;
    }

    /**
     *	电子信用显示
     */
    public function index(Request $request)
    {
    	$route = $request->path();
    	$data = [
    		'cate_id' => 1,
    	];
    	$dianzi = $this->credit->credits($data);
    	$webset = \DB::table('webset')->first();
    	return view('wap.dianzi.index',compact('route','dianzi','webset'));
    }
}
