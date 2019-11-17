<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CreditRepository;
use App\Http\Requests\CreditRequest;

class CreditController extends Controller
{
    
    /**
     *  账单仓库
     */
    protected $credit;

    /**
     *  实例化仓库 
     */
    public function __construct(CreditRepository $credit)
    {
        $this->credit = $credit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = [
            'cate_id' => $request->get('cate_id') ? trim($request->get('cate_id')) :'',
        ];
        $pathinfo = $this->credit->CommonPathInfo();
        $credits = $this->credit->credits($whereData);
        //dump($credits);
        return view('admin.credit.index',compact('pathinfo','credits','whereData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.credit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditRequest $request)
    {
        $data = [
            "cate_id" => $request->get('cate_id'),
            "credit_name" => $request->get('credit_name'),
            "week_salary" => $request->get('week_salary'),
            "month_salary" => $request->get('month_salary'),
            "amount" => $request->get('amount')
        ];

        if(!$this->credit->CommonSave($data)){
            return JsonResponse::JsonData(ApiErrDesc::CREDIT_SAVE_FAIL[0],ApiErrDesc::CREDIT_SAVE_FAIL[1]);
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
        $credit = $this->credit->GetOne($id);
        //dump($credit);
        return view('admin.credit.edit',compact('credit'));
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
        $id = $request->get('c_id');

        $data = [
            "cate_id" => $request->get('cate_id'),
            "credit_name" => $request->get('credit_name'),
            "week_salary" => $request->get('week_salary'),
            "month_salary" => $request->get('month_salary'),
            "amount" => $request->get('amount')
        ];

        if(!$this->credit->CommonUpdate($id,$data)){
            return JsonResponse::JsonData(ApiErrDesc::CREDIT_UPDATE_FAIL[0],ApiErrDesc::CREDIT_UPDATE_FAIL[1]);
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
        if(!$this->credit->CommonDelete($id)){
             return JsonResponse::JsonData(ApiErrDesc::CREDIT_DELTED_FAIL[0],ApiErrDesc::CREDIT_DELTED_FAIL[1]);
        };
        return JsonResponse::ResponseSuccess();
    }
}
