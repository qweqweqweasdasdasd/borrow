<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerRequest;
use App\Repositories\ManagerRepository;
use App\Repositories\RoleRepository;


class ManagerController extends Controller
{
    /**
     *  管理员仓库
     */
    protected $manager;

    /**
     *  角色仓库
     */
    protected $role;

    /**
     * 初始化仓库
     */
    public function __construct(ManagerRepository $manager,RoleRepository $role)
    {
        $this->role = $role;
        $this->manager = $manager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = [
            'k' => $request->get('k') ? trim($request->get('k')) :'',
            'start' => $request->get('start') ? trim($request->get('start')) :'',
            'end' => $request->get('end') ? trim($request->get('end')) :'',
        ];
        
        $pathinfo = $this->manager->CommonPathInfo();
        $managers = $this->manager->GetManagers($whereData);

        foreach($managers as $k => $v){
            $v->ip = $v->ip ? long2ip($v->ip) : '';
            $v->last_login_time = $v->last_login_time ? date('Y-m-d H:i:s',$v->last_login_time) :'';
        }
        //dump($managers);
        return view('admin.manager.index',compact('pathinfo','managers','whereData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allocationRoleData = $this->role->AllocationRoleData();
        //dump($allocationRoleData);
        return view('admin.manager.create',compact('allocationRoleData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagerRequest $request)
    {
        $data = [
            'mg_name' => $request->get('mg_name'),
            'password' => $request->get('password'),
            'mg_status' => $request->get('mg_status'),
            'email' => $request->get('email'),
        ];

        \DB::beginTransaction();
        try {
            $manager = $this->manager->ManagerSave($data);
            $manager->roles()->sync($request->get('role_ids'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return JsonResponse::JsonData(ApiErrDesc::MANAGER_SAVE_FAIL[0],ApiErrDesc::MANAGER_SAVE_FAIL[1]);
        }

        return JsonResponse::ResponseSuccess();
    }

    /**
     * 修改状态
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {   
        $status = $request->get('status');
        if(!$this->manager->CommonSetStatus($id,$status)){
             return JsonResponse::JsonData(ApiErrDesc::MANAGER_UPDATE_STATUS_FAIL[0],ApiErrDesc::MANAGER_UPDATE_STATUS_FAIL[1]);
        };
        return JsonResponse::ResponseSuccess();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manager = $this->manager->ManagerWithRole($id);
        $allocationRoleData = $this->role->AllocationRoleData();

        $in_manager_roles_id = [];
        foreach ($manager->roles as $k => $role) {
            $in_manager_roles_id[] = $role->role_id;
        }

        //dump($in_manager_roles_id);
        return view('admin.manager.edit',compact('manager','allocationRoleData','in_manager_roles_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $request->get('mg_id');

        $data = [
            'mg_name' => $request->get('mg_name') ? trim($request->get('mg_name')):'',
            'mg_status' => $request->get('mg_status') ? trim($request->get('mg_status')):'',
            'email' => $request->get('email') ? trim($request->get('email')):'',
        ];
        
        \DB::beginTransaction();
        try {
            $manager = $this->manager->ManagerUpdate($id,$data);
            $manager->roles()->sync($request->get('role_ids'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return JsonResponse::JsonData(ApiErrDesc::MANAGER_UPDATE_FAIL[0],ApiErrDesc::MANAGER_UPDATE_FAIL[1]);
        }

        return JsonResponse::ResponseSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $this->manager->CommonDelete($id);
            $this->manager->DeleteRelation($id);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return JsonResponse::JsonData(ApiErrDesc::MANAGER_DELETE_FAIL[0],ApiErrDesc::MANAGER_DELETE_FAIL[1]);
        }
        
        return JsonResponse::ResponseSuccess();
    }

    
}
