<?php
namespace App\Lib\Server;

use App\Bill;
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

	/**
	 *	请求扣分
	 */
	public function Deduct($data)
	{
		if( empty($data['userAccount']) || empty($data['userAccount'])){
			throw new \Exception("参数不全!");
		}
		$note = 'account:'.$data['userAccount'] . '-' . 'money' . ':' .$data['balance'] . '-manager:' . \Auth::guard('admin')->user()->mg_name . '-hkTime:' . date('Y-m-d H:i:s',time());
		
		$d = [
			'balance' => $data['balance'],
			'damaMultiple' => $data['balance'],
			'note' => $note,					// 谁-金额是多少-操作者谁-操作时间
    		'userAccount' => $data['userAccount'],
		];

		$res = (new KKbet)->subtractPoint($d);
		
		// 添加成功修改数据库
		if($res['code'] == 200){
			(new Bill)->subtractPointSuccess($d,$data['b_id']);
		}
		if($res['code'] != 200 && $res['code'] != 101){

		}
		return $res;
	}

	/** 
	 *	请求上分
	 */
	public function Point($data)
	{
		if( empty($data['userAccount']) || empty($data['userAccount'])){
			throw new \Exception("参数不全!");
		}
		$note = 'account:'.$data['userAccount'] . '-' . 'money' . ':' .$data['balance'] . '-manager:' . \Auth::guard('admin')->user()->mg_name . '-doingTime:' . date('Y-m-d H:i:s',time());
		
		$d = [
			'balance' => $data['balance'],
			'damaMultiple' => $data['balance'],
			'note' => $note,					// 谁-金额是多少-操作者谁-操作时间
    		'userAccount' => $data['userAccount'],
		];

		$res = (new KKbet)->addPoint($d);
		
		// 添加成功修改数据库
		if($res['code'] == 200){
			(new Bill)->PointSuccess($d,$data['b_id']);
		}
		if($res['code'] != 200 && $res['code'] != 101){
			(new Bill)->PointFail($d,$data['b_id']);
		}
		return $res;

	}
}