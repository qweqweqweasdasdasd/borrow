<?php

/**
 *	前台
 */
// 首页跳转
Route::get('/','Wap\IndexController@goto');

Route::get('jiekuan','Wap\JiekuanController@index');

Route::post('jiekuan/submit','Wap\JiekuanController@submit');

//	电子信用额度
Route::get('/dianzi','Wap\DianziController@index');

//	真人信用额度
Route::get('/zhenren','Wap\ZhenrenController@index');

//  借还款记录
Route::get('/records','Wap\RecordsController@index');

//  我要还款
Route::get('/hk','Wap\IndexController@hk');

//	信用规则
Route::get('/index','Wap\IndexController@index');

// 查询会员
Route::post('/sousou','Wap\IndexController@sousou');

Route::get('/alert','Wap\IndexController@alert');