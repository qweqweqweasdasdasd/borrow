<?php
namespace App\Lib\Server;

use Illuminate\Support\Facades\Redis;

/**
 * 	redis
 */
class RedisServer
{

	/**
	 *	非平台用户集合添加
	 */
	public function addNotPlatformValue($username)
	{
		$notPlatformKey = config('common.redis_keys.pre').config('common.redis_keys.jiekuan.pre').config('common.redis_keys.jiekuan.userAccountNotInPlatform');
		return Redis::sadd($notPlatformKey,$username);
	}

	/**
	 *	非平台用户查询是否存在
	 */
	public function existPlatformValue($username)
	{
		$notPlatformKey = config('common.redis_keys.pre').config('common.redis_keys.jiekuan.pre').config('common.redis_keys.jiekuan.userAccountNotInPlatform');

        if(Redis::sismember($notPlatformKey,$username)){
            throw new \Exception("{$username}非平台用户,请不要重复提交!");
        };
	}

	/**
	 *	用户提交之后待申请 有序集合 ??不合理??
	 */
	public function addAccountToApplyStatusList($username)
	{
		$accountStatusKey = config('common.redis_keys.pre').config('common.redis_keys.jiekuan.pre').config('common.redis_keys.jiekuan.addAccountToApplyStatusList');

        return Redis::zAdd($accountStatusKey,1,$username);
	}
}