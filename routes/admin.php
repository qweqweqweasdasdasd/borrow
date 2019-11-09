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
	Route::resource('manager','Admin\ManagerController');			// 后台管理--管理员管理
	Route::resource('role','Admin\RoleController');					// 后台管理--角色管理
	Route::match(['get','post'],'role/allocation/{role}','Admin\RoleController@allocation');	// 后台管理--权限分配
	Route::resource('permission','Admin\PermissionController');		// 后台管理--权限管理

	Route::resource('borrowapply','Admin\BorrowApplyController');		// 后台管理--借款管理
	
});

Route::get('session','Admin\LoginController@get');				//	测试
