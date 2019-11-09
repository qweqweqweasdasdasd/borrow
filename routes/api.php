<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 *	用户登录 ?? 
 */
Route::post('login','Api\MemberController@login');

/**
 *	用户登出 ??
 */
Route::post('logout','Api\MemberController@logout');

/**
 *	公用接口--验证码
 */
Route::any('captcha','Api\CaptchaController@captcha');


// 模拟系统管理员接口

Route::any('borrow/getUserInfo','Api\BorrowController@getUserInfo');		// 获取会员账号信息

Route::any('borrow/addPoint','Api\BorrowController@addPoint');				// 添加分数

Route::any('borrow/subtractPoint','Api\BorrowController@subtractPoint');	// 扣除分数

Route::any('borrow/heartbeat','Api\BorrowController@heartbeat');			// 心跳包



