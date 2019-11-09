<?php
namespace App\Repositories;

use App\Permission;

class PermissionRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $permission;

    /**
     *  状态字段
     */
    public $status = 'ps_status';

    /**
     *  主键字段
     */
    public $primaryKey = 'ps_id';

    /**
     * 	初始化模型
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
        $this->common = $permission;
        parent::__construct();
    }

    /**
     *	获取权限树形列表
     */
    public function PermissionTree()
    {
    	return generateTree($this->permission::get()->toArray());
    }

    /**
     *	获取到权限所有数据
     */
    public function GetPermissions()
    {
    	return $this->permission::get();
    }

    /**
     *	创建权限数据
     */
    public function PermissionSave($data)
    {
    	$data['level'] = $this->generateLevel($data['pid']);
        //dd($data);
    	return $this->CommonSave($data);
    }

    /**
     *	更新权限数据
     */
    public function PermissionUpdate($id,$data)
    {
    	
        $data['level'] = $this->generateLevel($data['pid']);
        //dd($data);
    	return $this->CommonUpdate($id,$data);
    }

    /**
     *  获取到指定层级权限
     */
    public function GetPermission($level)
    {
        return $this->permission::orderBy('ps_id','desc')->where('level',$level)->get();
    }

    /**
     *	删除权限数据
     */
    public function PermissionDelte($id)
    {
    	if(!$this->SubclassExist($id)){
    		return $this->permission::where($this->primaryKey,$id)->delete();
    	};
    	return false;
    }

    /**
     *	查询id权限是否有子类权限
     */
    public function SubclassExist($id)
    {
    	return $this->permission::where('pid',$id)->count();
    }
   
}