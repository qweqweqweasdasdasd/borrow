<?php
namespace App\Lib\Server;

use App\Lib\Borrow\KKbet;
use App\Lib\Server\RedisServer;

/**
 * 	从平台拉数据
 */
class Platfrom
{
	/**
	 *	注入参数
	 */
	protected $param = '';

	/**
	 *	从平台拉数据
	 */
	public function FromPlatfromPull()
	{
		$data = [
			'username' => $this->param['userAccount'],
		];

		$res = (new KKbet)->getUserInfo($data);

		// 判断平台不存在该用户
		if($res['code'] == 100){
			// 用户不存在记录到redis列表
			(new RedisServer)->addNotPlatformValue($data['username']);
		}
		return $res;
	}

	/** 
	 *	设置参数
	 */
	public function setParam($param)
	{
		if(!is_array($param)){
			throw new \Exception("注入参数不为数组!");
		}
		$this->param = $param;
		return $this;
	}
}