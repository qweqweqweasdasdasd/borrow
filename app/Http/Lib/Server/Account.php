<?php
namespace App\Lib\Server;

use App\Lib\Borrow\KKbet;
use App\Lib\Server\Base;
use App\Member;

/**
 * 	用户借贷提交审核
 */
class Account extends Base
{
	/**
	 *	注入参数
	 */
	protected $param = '';

	
	/**
	 *	设置表单提交参数
	 */
	public function setParam($data)
	{
		if(!is_array($data)){
			throw new \Exception("注入参数不为数组!");
		}
		$this->param = $data;
		return $this;
	}
}