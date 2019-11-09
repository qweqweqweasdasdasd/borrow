<?php 
namespace App\Response;

use App\ErrDesc\ApiErrDesc;

/**
 *  统一返回 json 数据
 */
class JsonResponse
{
	/**
	 *	返回错误json格式
	 */
	public static function JsonData($code,$msg,$data=[])
	{
		$content = [
			'code' => $code,
			'msg'  => $msg,
			'data' => $data
		];

		return self::ToJson($content);
	}

	/**
	 *	返回成功json格式
	 */
	public static function ResponseSuccess($d = [])
	{
		$content = [
			'code' => ApiErrDesc::CODE_OK[0],
			'msg'  => ApiErrDesc::CODE_OK[1],
			'data' => $d
		];

		return self::ToJson($content);
	}

	/**
	 *	返回json格式信息
	 */
	public static function ToJson($d)
	{
		$response = [
			'code' => $d['code'],
			'msg' => $d['msg'],
			'data' => $d['data'],
		];

		return json_encode($response);
	}
}