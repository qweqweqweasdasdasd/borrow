<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Permission;
use Illuminate\Support\Facades\Redis;

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
        return !!($this->mg_id == 1);
    }
    /**
     *  管理员所属的权限列表
     */
    public function hasPermissionList()
    {
        $key = config('common.redis_keys.pre') . config('common.redis_keys.permission.pre') . config('common.redis_keys.permission.checkManagerHasPermission') . $this->mg_id;
        
        $permissionArray = Redis::get($key);
        if(!$permissionArray){
            $roles = $this->roles;
            $ca = [];
            foreach ($roles as $k => $role) {
                $permissions = $role->permissions;
                foreach ($permissions as $kk => $permission) {
                   $ca[] = strtolower($permission->ps_c . '-' . $permission->ps_a); 
                }
            }

            // 不需要验证的权限
            $allow = Permission::select(\DB::raw('concat(ps_c,"-",ps_a) as ca'))
                                ->where('is_verfy',2)
                                ->whereNotNull('ps_c')
                                ->get(['ca'])
                                ->toArray();
            $allow_arr = [];
            foreach ($allow as $k => $v) {
                $allow_arr[] = $v['ca'];
            }

            $permissionArray = json_encode(array_unique(array_merge($allow_arr,$ca)));
            Redis::set($key,$permissionArray);
            Redis::expire($key,config('common.redis_keys.permission.expire'));
        };

        return $permissionArray;
    }
}
