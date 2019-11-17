<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BillRepository;

class RecordsController extends Controller
{
    /**
     *  账单仓库
     */
    protected $bill;

    /**
     *  初始化数据
     */
    public function __construct(BillRepository $bill)
    {
        $this->bill = $bill;
    }

    /**
     *  电子信用显示
     */
    public function index(Request $request)
    {
        $route = $request->path();
        $bills = $this->bill->bills();
        $webset = \DB::table('webset')->first();
        return view('wap.records.index',compact('route','bills','webset'));
    }
}
