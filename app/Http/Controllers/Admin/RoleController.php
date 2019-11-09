<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\PermissionRepository;

class RoleController extends Controller
{
    /**
     *  角色仓库
     */
    protected $role;

    /**
     *  管理员仓库
     */
    protected $manager;

    /**
     *  权限仓库
     */
    protected $permission;


    /**
     * 初始化仓库
     */
    public function __construct(RoleRepository $role,ManagerRepository $manager,PermissionRepository $permission)
    {
        $this->role = $role;
        $this->manager = $manager;
        $this->permission = $permission;
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
            'start' => $request->get('start') ? trim($request->get('start')):'',
            'end' => $request->get('end') ? trim($request->get('end')):'',
        ];

        $pathinfo = $this->role->CommonPathInfo();
        $roles = $this->role->GetRoles($whereData);
        //dump($roles);
        return view('admin.role.index',compact('pathinfo','roles','whereData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allocationManagerData = $this->manager->AllocationManagerData();
        //dump($allocationManagerData);
        return view('admin.role.create',compact('allocationManagerData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $data = [
            'role_name' => $request->get('role_name'),
            'role_status' => $request->get('role_status'),
            'desc' => $request->get('desc'),
        ];

        \DB::beginTransaction();
        try {
            $role = $this->role->CommonSave($data);
            $role->managers()->sync($request->get('mg_ids'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return JsonResponse::JsonData(ApiErrDesc::ROLE_SAVE_FAIL[0],ApiErrDesc::ROLE_SAVE_FAIL[1]);
        }
        
        return JsonResponse::ResponseSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $status = $request->get('status');
        if(!$this->role->CommonSetStatus($id,$status)){
             return JsonResponse::JsonData(ApiErrDesc::ROLE_UPDATE_STATUS_FAIL[0],ApiErrDesc::ROLE_UPDATE_STATUS_FAIL[1]);
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
        $role = $this->role->GetOne($id);
        $allocationManagerData = $this->manager->AllocationManagerData();
        
        $in_role_mg_id = [];
        foreach ($role->managers as $k => $manager) {
            $in_role_mg_id[] = $manager->mg_id;
        }
        //dump($in_role_mg_id);
        return view('admin.role.edit',compact('role','allocationManagerData','in_role_mg_id'));
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
        $id = $request->get('role_id');

        $data = [
            'role_name' => $request->get('role_name'),
            'role_status' => $request->get('role_status'),
            'desc' => $request->get('desc'),
        ];

        \DB::beginTransaction();
        try {
            $role = $this->role->RoleUpdate($id,$data);
            $role->managers()->sync($request->get('mg_ids'));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return JsonResponse::JsonData(ApiErrDesc::ROLE_UPDATE_FAIL[0],ApiErrDesc::ROLE_UPDATE_FAIL[1]);
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
            $this->role->CommonDelete($id);
            $this->role->DeleteRelation($id);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return JsonResponse::JsonData(ApiErrDesc::ROLE_DELETE_FAIL[0],ApiErrDesc::ROLE_DELETE_FAIL[1]);
        }
        
        return JsonResponse::ResponseSuccess();
    }

    /**
     *  给角色分配权限
     */
    public function allocation(Request $request, $id)
    {
        if($request->isMethod('post')){
            $role = $this->role->GetOne($id);
            $ps_ids = $request->get("ps_ids");
            if(is_null($ps_ids)){
                return JsonResponse::JsonData(ApiErrDesc::ROLE_ALLOCATION_FAIL[0],ApiErrDesc::ROLE_ALLOCATION_FAIL[1]);
            }
            $role->permissions()->sync($ps_ids);
            return JsonResponse::ResponseSuccess(); 
        }

        $role = $this->role->Role($id);
        $permission_i = $this->permission->GetPermission(1);
        $permission_ii = $this->permission->GetPermission(2);
        
        $in_role_permission_id = [];
        foreach ($role->permissions as $k => $permission) {
            $in_role_permission_id[] = $permission->ps_id;
        }
        //dump($in_role_permission_id);
        return view('admin.role.allocation',compact('role','permission_i','permission_ii','in_role_permission_id'));
    }
}
