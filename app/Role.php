<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
	protected $table = 'role';
    protected $fillable = [
    	'role_name','desc','role_status',
    ];
    
    /**
     *  管理员与角色对应关系--多对多关系
     */ 
    public function managers()
    {
        return $this->belongsToMany('App\Manager','manager_role','role_id','mg_id')->withTimestamps();
    }

    /**
     *  角色与权限对应关系--多对多关系
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission','role_permission','role_id','ps_id')->withTimestamps();
    }
}
