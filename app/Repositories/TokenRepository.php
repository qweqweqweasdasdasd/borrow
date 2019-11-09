<?php
namespace App\Repositories;

use App\Token;

class TokenRepository
{
  	/**
  	 *	令牌对象
  	 */
  	protected $token;


    /**
     * 	初始化模型
     */
    public function __construct(Token $token)
    {
    	$this->token = $token;
    }
   	
   	/**
   	 *	创建令牌
   	 */
   	public function tokenSave($data)
   	{
   		return $this->token->create($data);
   	}

   	/**
   	 *	获取到指定的一条数据
   	 */
   	public function GetOne($key = '')
   	{
   		return $this->token->find();
   	}
}