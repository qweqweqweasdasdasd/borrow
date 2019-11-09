<?php
namespace App\Repositories;

use App\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $manager;

    /**
     *  状态字段
     */
    public $status = 'mg_status';

    /**
     *  主键字段
     */
    public $primaryKey = 'mg_id';

    /**
     *  初始化模型
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        $this->common = $manager;
        parent::__construct();
    }

    /**
     *  分配管理员数据
     */
    public function AllocationManagerData()
    {
        return $this->manager::get(['mg_id','mg_name','mg_status']);
    }

    /**
     *  获取到管理员所有数据
     */
    public function GetManagers($d)
    {
        $list = $this->manager::with('roles')->orderBy('mg_id','desc');

        // 关键字查询
        if(!empty($d['k'])){
            $list->where('mg_name',$d['k']);
        }

        // 根据时间查询
        if(!empty($d['start']) && !empty($d['end'])){
            $list->whereBetween('created_at',[$d['start'],$d['end']] );
        }
        
        return $list->paginate(9);
    }

    /**
     *  获取到一条 manager 数据 with role
     */
    public function ManagerWithRole($id)
    {
        return $this->manager->with(['roles'])->where($this->primaryKey,$id)->first();
    }

    /**
     *  管理员更新数据
     */
    public function ManagerUpdate($id,$d)
    {
        $manager = $this->manager::find($id);
        $manager->mg_name = $d['mg_name'];
        $manager->mg_status = $d['mg_status'];
        $manager->email = $d['email'];
        $manager->save(); 
        return $manager;
    }

    /**
     *  通过管理员id删除关系表
     */
    public function DeleteRelation($id)
    {
        return \DB::table('manager_role')->where('mg_id',$id)->delete();
    }

    /**
     *  创建管理员
     */
    public function ManagerSave($d)
    {
        $d = [
            'mg_name' => $d['mg_name'],
            'password' => Hash::make($d['password']),
            'mg_status' => $d['mg_status'],
            'email' => $d['email'],
        ];
        
        return $this->CommonSave($d);
    }

}