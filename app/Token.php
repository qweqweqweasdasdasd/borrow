<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Token extends Model
{
	/**
	 *	令牌键
	 */
	protected $key;

    /**
     * 	初始化模型
     */
    public function __construct()
    {
    	$this->key = config('common.redis_keys.pre') . config('common.redis_keys.token.pre') . config('common.redis_keys.token.tokenSave');
    }

    /**
     *	更新保存
     */
    public function create($data)
    {
    	$string = json_encode($data);

    	return Redis::set($this->key,$string);
    }

    /**
     *	find 改写
     */
    public function find($key ='')
    {
    	$key = $key ? $key : $this->key;
   		$string = Redis::get($this->key);
   		return json_decode($string);
    }
}
