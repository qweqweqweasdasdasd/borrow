<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\VipRepository;
use App\Http\Requests\VipRequest;

class VipController extends Controller
{
    /**
     *  权限仓库
     */
    protected $vip;

    /**
     * 初始化仓库
     */
    public function __construct(VipRepository $vip)
    {
        $this->vip = $vip;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pathinfo = $this->vip->CommonPathInfo();
        $vips = $this->vip->vips();
        foreach ($vips as $k => $v) {
            $v->borrow_balance = number_format($v->borrow_balance);
        }
        //dump($pathinfo);
        return view('admin.vip.index',compact('pathinfo','vips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vip.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VipRequest $request)
    {
        $data = [
            'vipName' => strtolower($request->get('vipName')),
            'borrow_balance' => $request->get('borrow_balance'),
            'vip_status' => $request->get('vip_status')
        ];
        if(!$this->vip->CommonSave($data)){
            return JsonResponse::JsonData(ApiErrDesc::VIP_SAVE_FAIL[0],ApiErrDesc::VIP_SAVE_FAIL[1]);
        }
        return JsonResponse::ResponseSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $status = $request->get('status');
        if(!$this->vip->CommonSetStatus($id,$status)){
             return JsonResponse::JsonData(ApiErrDesc::VIP_UPDATE_STATUS_FAIL[0],ApiErrDesc::VIP_UPDATE_STATUS_FAIL[1]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
