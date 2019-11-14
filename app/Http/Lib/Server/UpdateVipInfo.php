<?php
namespace App\Lib\Server;

use App\Member;
use App\Lib\Server\Platfrom;


/**
 * 更新vip等级
 */
class UpdateVipInfo 
{
	
	/**
	 *	初始化
	 */
	public function __construct()
	{

	}

	/**
	 *	获取到指定id更新数据库
	 */
	public function UpdateVipToBy($response)
	{
		$vipName = $response['vipName'];
		$vip_id = (new Member)->transformToVipId($vipName);
		if(empty($vip_id)){
			throw new \Exception("vip系统后台vip更新,vip等级是否设置了!");
		}
		return Member::where('userAccount',$response['userAccount'])->update(['vip_id'=>$vip_id]);
	}


	/**
	 *	通过参数获取数据
	 */
	public function GetPlalformParam($param)
	{
		$res = (new Platfrom)->setParam($param)->FromPlatfromPull();
		// 平台无该用户 || 令牌过期
        if($res['code'] == 100 || $res['code'] == 101){
            throw new \Exception($res['msg']);
        }

        if($res['code'] == 200){
            $response = $res['data'];
        }

        return $response;
	}

}