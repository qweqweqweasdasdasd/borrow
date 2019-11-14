<?php 
namespace App\Lib\Borrow;

use QL\QueryList;
use App\Repositories\TokenRepository;

/**
 * 凯凯平台系统借呗活动,模拟接口服务
 */
class KKbet
{
	/**
	 *	后台域名
	 */
	protected $domain = 'http://wanmeiqpadmin1.com:1788';

	/**
	 *	querylist 对象
	 */
	protected $ql = '';

	/**
	 *	解析token
	 */
	protected $token = '';

	/**
	 *	初始化数据
	 */
	public function __construct()
	{	
		$this->ql = QueryList::getInstance();
		$this->getToken();
	}

	/**
	 *	获取token
	 */
	public function getToken()
	{
		$token = new \App\Token();
		$this->token = $token->find()->token;
	}
	/**
	 *	获取到用户个人信息
	 *	接口地址: http://wanmeiqpadmin1.com:1788/adminsystem/server/memberManager/findByMemberUserPageResult?pageNo=1&pageSize=20&userAccount=akai999
	 *	@userAccount: 会员账号
	 */
	public function getUserInfo($d)
	{
		if(empty($d['username'])){
			throw new \Exception("会员账号不得为空!");
		}

		$data = [
			'userAccount' => $d['username'],
		];

		$opt = [
			'headers' =>[
				'timeout' => 5,
				'Authorization' => $this->token
			]
		];

		$response = $this->ql->get($this->domain.'/adminsystem/server/memberManager/findByMemberUserPageResult',$data,$opt);

		$content = json_decode($response->getHtml(),true);

		// 用户不存在 status == 1 && result == null
		if($content['status'] == 1 && !count($content['data']['result'])){
			//throw new \Exception("平台查询没有 {$d['username']}");
			return ['code'=>100,'msg'=>"平台查询没有 {$d['username']}"];
		}
		// 用户存在,返回用户资料 status == 1 && result != null
		if($content['status'] == 1 && count($content['data']['result'])){
			return ['code'=>200,'msg'=>'success','data'=>($content['data']['result'][0])];
		}
		// 会话过期	status == 401
		if($content['status'] == 401){
			//throw new \Exception("会话过期!");	
			return ['code'=>101,'msg'=>'系统令牌过期,请联系客服处理!'];	
		}
	}

	/**
	 *	添加分数
	 *	接口地址: http://wanmeiqpadmin1.com:1788/adminsystem/server/memberManager/updateDeposit
	 *	@balance		// 存款金额
	 *	@damaMultiple	// 打码量
	 *	@note 			// 备注
	 *	@userAccount	// 会员账号
	 */
	public function addPoint($d)
	{
		if(empty($d['balance']) || empty($d['username'])){
			throw new \Exception("参数缺少!");
		}

		$data = [
			'balance' => $d['balance'],
			'damaMultiple' => $d['balance'],
			'note' => "",					// 谁-参加了什么活动-金额是多少-操作者谁
    		'userAccount' => $d['username'],
		];

		$opt = [
			'headers' =>[
				'timeout' => 5,
				'Authorization' => $this->token
			]
		];

		$response = $this->ql->postJson($this->domain.'/adminsystem/server/memberManager/updateDeposit',$data,$opt);

		$content = json_decode($response->getHtml(),true);

		// status == 1 && msg == SUCCESS
		if($content['status'] == 1 && $content['msg'] == 'SUCCESS'){
			return "{$d['username']} 存款成功,金额: {$d['balance']}";
		}
		
		// 会话过期	status == 401
		if($content['status'] == 401){
			throw new \Exception("会话过期!");	
		}
	}

	/**
	 *	扣除分数
	 *	接口地址: http://wanmeiqpadmin1.com:1788/adminsystem/server/memberManager/updateWithdraw
	 *	@balance 		// 金额
	 *	@note 			// 备注
	 *	@userAccount	// 用户账号
	 */
	public function subtractPoint($d)
	{
		if(empty($d['balance']) || empty($d['username'])){
			throw new \Exception("参数缺少!");
		}

		$data = [
			'balance' => $d['balance'],
			'note' => "",					// 谁-参加了什么活动-借款多少-自动扣除-操作者谁
    		'userAccount' => $d['username'],
		];

		$opt = [
			'headers' =>[
				'timeout' => 5,
				'Authorization' => $this->token
			]
		];

		$response = $this->ql->postJson($this->domain.'/adminsystem/server/memberManager/updateWithdraw',$data,$opt);

		$content = json_decode($response->getHtml(),true);
		// status == 1 && msg == SUCCESS
		if($content['status'] == 1 && $content['msg'] == 'SUCCESS'){
			return "{$d['username']} 扣除成功,金额: {$d['balance']}";
		}
		
		// 会话过期	status == 401
		if($content['status'] == 401){
			throw new \Exception("会话过期!");	
		}
	}

	/**
	 *	心跳包
	 *	接口地址: http://wanmeiqpadmin1.com:1788/adminsystem/server/memberManager/findByMemberField
	 *	
	 */
	public function heartbeat()
	{
		$data = [];

		$opt = [
			'headers' =>[
				'timeout' => 5,
				'Authorization' => $this->token
			]
		];

		$response = $this->ql->get($this->domain.'/adminsystem/server/memberManager/findByMemberField',$data,$opt);
		//dump($response);
		$content = json_decode($response->getHtml(),true);

		// 会话过期	status == 1
		if($content['status'] == 1){
			return true;	
		}

		// 会话过期	status == 401
		if($content['status'] == 401){
			return false;	
		}
	}
}