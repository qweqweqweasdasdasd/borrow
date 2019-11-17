<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BillRepository;
use App\Lib\Server\Platfrom;

class HkbillController extends Controller
{
    /**
     *  账单仓库
     */
    protected $bill;

    /**
     *  实例化仓库 
     */
    public function __construct(BillRepository $bill)
    {
        $this->bill = $bill;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = [
            'userAccount' => !empty($request->get('userAccount'))?trim($request->get('userAccount')):'',
            'borrow_start' => !empty($request->get('borrow_start'))?trim($request->get('borrow_start')):'',
            'borrow_end' => !empty($request->get('borrow_end'))?trim($request->get('borrow_end')):'',
            'status' => !empty($request->get('status'))?trim($request->get('status')):'',
        ];

        $pathinfo = $this->bill->CommonPathInfo();
        $bills = $this->bill->hkbills($whereData);
        
        //dump($bills);
        return view('admin.hkbill.index',compact('pathinfo','whereData','bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $bill = $this->bill->GetOne($id);

        $data = [
            'b_id' => $id,
            'balance' => $request->get('money'),
            'userAccount' => $bill->userAccount,
        ];

        // 调用接口
        $response = (new Platfrom)->Deduct($data);
        //dd($response);
        // 会话失效
        if($response['code'] == 101){
            return JsonResponse::JsonData(ApiErrDesc::CODE_ERR[0],$response['msg']);
        }

        // 扣分成功
        if($response['code'] == 200){
            $d = [
                'data' => $response['data'],
            ];
            return JsonResponse::ResponseSuccess($d);
        }
        // 扣除金额不足
        if($response['code'] == 102){
            return JsonResponse::JsonData(ApiErrDesc::CODE_ERR[0],$response['msg']);
        }

        // 不知原因失败
        return JsonResponse::JsonData(ApiErrDesc::CODE_ERR[0],'不知原因失败!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $bill = $this->bill->GetOne($id);

        return view('admin.hkbill.edit',compact('bill'));
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
         $id = $request->get('b_id');

        $data = [
            'desc' =>$request->get('desc')
        ];
        if(!$this->bill->CommonUpdate($id,$data)){
            return JsonResponse::JsonData(ApiErrDesc::HKBILL_UPDATE_FAIL[0],ApiErrDesc::HKBILL_UPDATE_FAIL[1]);
        };
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
        //
    }
}
