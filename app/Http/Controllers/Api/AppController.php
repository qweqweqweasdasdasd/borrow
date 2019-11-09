<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
	/**
	 *	keys 
	 */
	protected $key = '';

    /**
     *	规定时间内不允许重复提交
     */

    /**
     *	生成 key 数值
     */
    public function createKey($value='')
    {
    	$this->key = config('common.pre') . $this->nickname;
    	return $this->key;
    }
}
