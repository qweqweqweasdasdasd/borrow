<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     *	用户登录
     */
    public function login(Request $request)
    {
    	$credentials = request(['m_name','password']);

    	if(! $token = Auth::guard('api')->attempt($credentials)){
    		return response()->json(['error' => 'Unauthorized'], 401);
    	}
    	return $this->respondWithToken($token);
    }

    public function respondWithToken($token)
    {
    	return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     *	用户登出
     */
    public function logout()
    {
    	return response()->json(Auth::guard('api')->user());
    }
}
