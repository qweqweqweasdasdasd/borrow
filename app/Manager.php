<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $primaryKey = 'mg_id';
	protected $table = 'manager';
    protected $fillable = [
    	'mg_name','password','mg_status','ip','email','login_count','google_token','last_login_time','session_id'
    ];
    
    protected $rememberTokenName = '';

    //	管理员状态正常
    const MANAGER_NORMAL = 1;

    //  管理员状态停用
    const MANAGER_BAN = 2;

    /**
     *  管理员与角色对应关系--多对多关系
     */ 
    public function roles()
    {
        return $this->belongsToMany('App\Role','manager_role','mg_id','role_id')->withTimestamps();
    }

    /**
     *  管理员是否为超级管理员
     */
    public function isRoot()
    {
        return !!($this->mg_id == 11);
    }
    /**
     *  管理员所属的权限列表
     */
    public function hasPermissionList()
    {
        
        return $this->roles();
    }
}
