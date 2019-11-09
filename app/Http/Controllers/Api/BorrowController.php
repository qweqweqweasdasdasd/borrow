<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BorrowBillRepository;
use App\Repositories\BorrowApplyRepository;

class BorrowController extends Controller
{
 	/**
 	 *	借款仓库
 	 */
 	protected $borrowApply;

 	/**
 	 *	借款详情账单仓库
 	 */
 	protected $borrowBill;

	/**
	 *	初始化仓库
	 */
	public function __construct(BorrowApplyRepository $borrowApply,BorrowBillRepository $borrowBill)
	{
		$this->borrowApply = $borrowApply;
		$this->borrowBill = $borrowBill;
	}
	
    /**
     *	用户申请借款动作
     *	post
     *	会员账号 || 会员姓名 || 可借额度 || 借款金额 || 还款日期 || 验证码  
     */
    public function borrow(Request $request)
    {
    	dd($request->all());
    	// 查询数据库会员合法性

    	// 查询数据库会员符合要求

    	// 入库
    	
    	// 进入队列
    	dd($request->all());
    }

    /**
     *	入库--借款表||借款明细表
     */
    public function createdBorrowApplyBill()
    {
    	
    }
}
