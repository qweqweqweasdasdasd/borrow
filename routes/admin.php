<?php 

/**
 *	管理后台路由
 */
Route::get('login','Admin\LoginController@login')->name('login');			//	登录页面
Route::post('doLogin','Admin\LoginController@doLogin');						//	登录动作
Route::get('logout','Admin\LoginController@logout')->name('admin.logout');	//	登出动作


Route::group(['middleware'=>['auth:admin','FanQiang']],function(){

	Route::get('index','Admin\IndexController@index')->name('admin.index');			//	管理后台--显示首页
	Route::get('welcome','Admin\IndexController@welcome')->name('admin.welcome');	//	管理后台--welcome
	Route::resource('role','Admin\RoleController');												// 后台管理--角色管理
	Route::resource('manager','Admin\ManagerController');										// 后台管理--管理员管理
	Route::resource('permission','Admin\PermissionController');									// 后台管理--权限管理
	Route::match(['get','post'],'role/allocation/{role}','Admin\RoleController@allocation');	// 后台管理--权限分配

	Route::match(['get','post'],'platform/token','Admin\TokenController@token');				// 后台管理--设置平台auth

	Route::resource('member','Admin\MemberController');					// 后台管理--会员管理

	Route::resource('vip','Admin\VipController');						// 后台管理--vip等级管理

	Route::resource('borrowapply','Admin\BorrowApplyController');		// 后台管理--借款管理
	
	Route::post('upload','Admin\UploadController@upload');				// 后台管理--上传 excel || 
});

