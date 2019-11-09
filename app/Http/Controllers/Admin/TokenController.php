<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TokenRepository;


class TokenController extends Controller
{
	protected $token = '';

	/**
	 * 	实例化仓库
	 */
	public function __construct(TokenRepository $token)
	{
		$this->token = $token;
	}
	
    /**
     *	重置令牌
     */
    public function token(Request $request)
    {
    	if($request->isMethod('post')){
    		$token = $request->get('token');
    		if(empty($token)){
    			return JsonResponse::JsonData(ApiErrDesc::TOKEN_RESOURCE_EMPTY[0],ApiErrDesc::TOKEN_RESOURCE_EMPTY[1]);
    		}
    		if(!$this->token->tokenSave($request->all())){
    			return JsonResponse::JsonData(ApiErrDesc::TOKEN_SAVE_FAIL[0],ApiErrDesc::TOKEN_SAVE_FAIL[1]);
    		}
    		return JsonResponse::ResponseSuccess();
    	}
    	$token = $this->token->GetOne();
    	//dump($token);
    	return view('admin.token.token',compact('token'));
    }

}
