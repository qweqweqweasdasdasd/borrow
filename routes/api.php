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
 *	用户登录
 */
Route::post('login','Api\MemberController@login');

/**
 *	用户登出
 */
Route::post('logout','Api\MemberController@logout');

/**
 *	用户申请借款动作
 */
Route::post('borrow','Api\BorrowController@borrow');

/**
 *	公用接口--验证码
 */
Route::any('captcha','Api\CaptchaController@captcha');

