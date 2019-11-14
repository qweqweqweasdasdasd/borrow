<?php
namespace App\Lib\Server;

/**
 * 基类
 */
class Base
{
	/**
	 *	提交数据核对数据库数据一致性
	 */
	public function Verify($member)
	{
		// vip 状态判断
		if($member->vip->vip_status != 1){
			throw new \Exception("vip等级状态为关闭!");
		}

		// 判断vip是否为当日更新数据
		if( date('Y-m-d',strtotime($member->update_vip_time)) != date('Y-m-d',time())){
			dd('pass');
			$param = [
	            'm_id' => $member->m_id,
	            'userAccount' => $member->userAccount,
	        ];
			$response = (new UpdateVipInfo)->GetPlalformParam($param);
            (new UpdateVipInfo)->UpdateVipToBy($response);
		}
		
		// 核对手机号
		

		// vip 借款金额核对 总借款余额
		if($member->vip->borrow_balance < (int)$this->param['amount']){
			throw new \Exception("借款金额超出了{$member->vip->vipName}的借款金额!");
		}

		// vip 借款金额核对 不得超出剩余总借款金额
		$money = ($member->vip->borrow_balance - $member->balanced);
		if($money < (int)$this->param['amount']){
			throw new \Exception("借款金额还有{$money}元,请及时还款之后,即可借款");
		}

		return $member;
	}
}