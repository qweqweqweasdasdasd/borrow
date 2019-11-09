<?php 
namespace App\ErrDesc;

/**
 * 自定义api错误信息
 */
class ApiErrDesc
{
	/**
	 *	请求成功
	 */
	const CODE_OK = ['1','success'];

	/**
	 *	请求失败
	 */
	const CODE_ERR = ['0','fail'];

	/**
	 *	表单验证错误 422
	 */
	const FORM_ERR = ['422','laravel 表单验证错误'];

	/**
	 *	管理员api错误信息 1000
	 */
	const MANAGER_AUTH_ERR = ['1000','管理员账号或者密码错误!'];

	const MANAGER_BAN = ['1001','管理员状态为禁止登陆,请链接超级管理员!'];

	const MANAGER_SAVE_SUCCESS = ['1002','创建管理员信息成功!'];
	
	const MANAGER_SAVE_FAIL = ['1003','创建管理员信息失败!'];

	const MANAGER_UPDATE_STATUS_FAIL = ['1004','修改管理员状态失败!'];

	const MANAGER_UPDATE_FAIL = ['1005','修改管理员信息失败!'];

	const MANAGER_DELETE_FAIL = ['1006','删除管理员信息失败!'];

	/**
	 *	角色api错误信息 2000
	 */
	const ROLE_SAVE_FAIL = ['2000','创建角色信息失败!'];

	const ROLE_UPDATE_STATUS_FAIL = ['2001','修改角色状态失败!'];

	const ROLE_UPDATE_FAIL = ['2002','更新角色信息失败!'];

	const ROLE_DELETE_FAIL = ['2003','删除角色信息失败!'];
	
	/**
	 *	权限api错误信息 3000
	 */
	const PERMISSION_SAVE_FAIL = ['3000','创建权限信息失败!'];

	const PERMISSION_UPDATE__FAIL = ['3001','更新权限信息失败!'];

	const PERMISSION_DELETE_FAIL = ['3002','该权限拥有子类无法删除!'];

	const ROLE_ALLOCATION_FAIL = ['3003','权限不得为空!'];

	/**
	 *	api 接口自定义错误
	 */
	const CAPTCHA_CREATE_FAIL = ['4000','验证码生成失败!'];

	const CAPTCHA_REQUEST_EMPTY = ['4001','会员账号为空!'];


	/**
	 *	借款管理
	 */
	const BORROWAPPLY_DELETE_FAIL = ['5000','借款列表删除失败!'];
	
}