<?php
namespace App\Repositories;

use App\Role;
use Illuminate\Support\Facades\Hash;

class RoleRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $role;

    /**
     *  状态字段
     */
    public $status = 'role_status';

    /**
     *  主键字段
     */
    public $primaryKey = 'role_id';

    /**
     * 	初始化模型
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
        $this->common = $role;
        parent::__construct();
    }
    /**
     *  分配角色数据
     */
    public function AllocationRoleData()
    {
      return $this->role::get(['role_id','role_status','role_name']);
    }
    /**
     *	获取到角色所有数据
     */
    public function GetRoles($d)
    {
    	$list = $this->role::with(['managers'])->orderBy('role_id','desc');

    	if(!empty($d['k'])){
    		$list->where('role_name',$d['k']);
    	}

    	// 根据时间查询
        if(!empty($d['start']) && !empty($d['end'])){
            $list->whereBetween('created_at',[$d['start'],$d['end']] );
        }

    	return $list->paginate(9);
    }

    /**
     *  获取到指定一条角色
     */
    public function Role($id)
    {
        return $this->role::with('managers')->find($id);
    }

    /**
     *  通过 角色id 删除关系表
     */
    public function DeleteRelation($id)
    {
        return \DB::table('manager_role')->where('role_id',$id)->delete();
    }

    /**
     *  更新角色
     */
    public function RoleUpdate($id,$d)
    {
        $role = $this->role::find($id);
        $role->role_name = $d['role_name'];
        $role->role_status = $d['role_status'];
        $role->desc = $d['desc'];
        $role->save(); 
        return $role;
    }

   	/**
   	 *	创建角色
   	 */
   	public function RoleSave($d)
   	{
   		
   	}

}