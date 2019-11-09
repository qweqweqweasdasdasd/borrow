<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    /**
     *  权限仓库
     */
    protected $permission;

    /**
     * 初始化仓库
     */
    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pathinfo = $this->permission->CommonPathInfo();
        //$permissions = $this->permission->GetPermissions();
        $psTree = ($this->permission->PermissionTree());
        
        foreach ($psTree as $k => &$tree) {
            $tree['ps_name_item'] = str_repeat('|-', $tree['level']).$tree['ps_name'];
        }

        //dump($permissions);
        return view('admin.permission.index',compact('pathinfo','psTree'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $psTree = ($this->permission->PermissionTree());

        foreach ($psTree as $k => &$tree) {
            $tree['ps_name_item'] = str_repeat('|-', $tree['level']).$tree['ps_name'];
        }

        //dump($psTree);
        return view('admin.permission.create',compact('psTree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $data = [
            'ps_name' => $request->get('ps_name'),
            'ps_c' => $request->get('ps_c'),
            'ps_a' => $request->get('ps_a'),
            'route' => $request->get('route'),
            'is_show' => $request->get('is_show'),
            'is_verfy' => $request->get('is_verfy'),
            'pid' => $request->get('pid'),
        ];
        //dd($request->all());
        if(!$this->permission->PermissionSave($data)){
            return JsonResponse::JsonData(ApiErrDesc::PERMISSION_SAVE_FAIL[0],ApiErrDesc::PERMISSION_SAVE_FAIL[1]);
        }
        return JsonResponse::ResponseSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->permission->GetOne($id);
        $psTree = ($this->permission->PermissionTree());
        //dump($permission); 
        foreach ($psTree as $k => &$tree) {
            $tree['ps_name_item'] = str_repeat('|-', $tree['level']).$tree['ps_name'];
        }

        return view('admin.permission.edit',compact('psTree','permission'));
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
        $data = [
            'ps_name' => $request->get('ps_name'),
            'ps_c' => $request->get('ps_c'),
            'ps_a' => $request->get('ps_a'),
            'route' => $request->get('route'),
            'is_show' => $request->get('is_show'),
            'is_verfy' => $request->get('is_verfy'),
            'pid' => $request->get('pid'),
        ];
        //dd($request->all());
        if(!$this->permission->PermissionUpdate($id,$data)){
            return JsonResponse::JsonData(ApiErrDesc::PERMISSION_UPDATE__FAIL[0],ApiErrDesc::PERMISSION_UPDATE__FAIL[1]);
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
        if(!$this->permission->PermissionDelte($id)){
           return JsonResponse::JsonData(ApiErrDesc::PERMISSION_DELETE_FAIL[0],ApiErrDesc::PERMISSION_DELETE_FAIL[1]);
        }
        return JsonResponse::ResponseSuccess();
    }
}
