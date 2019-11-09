<?php

namespace App\Http\Controllers\Api;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Redis;

class CaptchaController extends AppController
{
	/**
	 *	request 对象
	 */
	protected $request = '';

	/**
	 *	会员昵称
	 */
	protected $nickname = '';

	/**
	 *	charset 随机字符串
	 */
	protected $charset = '0123456789';

	/**
	 *	显示数量
	 */
	protected $showNu = 5;

	/**
	 *	实例化 request 对象 
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}
	
    /**
     *	验证码接口: 获取到二维码把验证写入redis
     *	post
     *	会员账号 || 
     */
    public function captcha(Request $request)
    {
    	try {
    		$this->requestCheck();					// 检测来源数据
    		$this->createKey();						// 生成keys
    		$captcha = $this->createCaptcha();		// 生成二维码
    	} catch (\Exception $e) {
    		return JsonResponse::JsonData(ApiErrDesc::CAPTCHA_REQUEST_EMPTY[0],ApiErrDesc::CAPTCHA_REQUEST_EMPTY[1]);
    	}

    	if(empty($captcha)){
    		return JsonResponse::JsonData(ApiErrDesc::CAPTCHA_CREATE_FAIL[0],ApiErrDesc::CAPTCHA_CREATE_FAIL[1]);
    	}
    	
    	$response = [
    		'captcha' => $captcha,
    	];

    	return JsonResponse::ResponseSuccess($response);
    }

	/**
	 *	来源数据检验
	 */
	public function requestCheck()
	{
    	$this->nickname = !empty($this->request->get('nickname')) ? trim($this->request->get('nickname')) : '';
    	if(empty($this->nickname)){
    		throw new \Exception("request is empty");
    	};
	}

    /**
     *	生成验证码
     */
    public function createCaptcha()
    {
    	$phrase = new PhraseBuilder();
    	$code = $phrase->build($this->showNu,$this->charset);
    	$builder = new CaptchaBuilder($code,$phrase);
        $builder->build($width = 100, $height = 40, $font = null);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->save('out.jpg');
        $phrase = $builder->getPhrase();
        Redis::set($this->key,$phrase);
        $base64 = $builder->inline();
		return $base64;
    }

}
