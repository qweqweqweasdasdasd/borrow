<?php 
namespace App\Lib\Command;

use DB;
use App\Bill;

/**
 *  自动查询到期生成还款订单
 */
class AutoGenerateBill 
{
	/**
	 *	判断是否符合条件  
	 *	到期 || 状态为成功 || 生成还款订单
	 */
	public function Fillter()
	{
		$whereData = [
			'status' => 2,
			'repayment_time' => date('Y-m-d',time())
		];

		$bills = Bill::where($whereData)->get();

		foreach ($bills as $k => $v) {
			$v->status = 4;
			$v->save();
		}
	}
}