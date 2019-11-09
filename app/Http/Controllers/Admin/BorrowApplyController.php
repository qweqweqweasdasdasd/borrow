<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BorrowApplyRepository;

class BorrowApplyController extends Controller
{
    /**
     *  借款列表仓库
     */
    protected $borrowApply;

    /**
     * 初始化仓库
     */
    public function __construct(BorrowApplyRepository $borrowApply)
    {
        $this->borrowApply = $borrowApply;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = $this->requestInit($request->all());
        $pathinfo = $this->borrowApply->CommonPathInfo();
        $borrowApply = $this->borrowApply->borrowApplys($whereData);

        foreach ($borrowApply as $k => $v) {
            $v->me_limit = $v->me_limit ? number_format($v->me_limit) :'';
            $v->borrow_total_money = $v->borrow_total_money ? number_format($v->borrow_total_money) :'';
            $v->repayment_total_money = $v->repayment_total_money ? number_format($v->repayment_total_money) :'';
            $v->arrearage = $v->arrearage ? '-'. $v->arrearage :'';
        }
        //dump($whereData);
        return view('admin.borrow.index',compact('pathinfo','borrowApply','whereData'));
    }


    /**
     *
     */
    public function requestInit($d)
    {

        if(!empty($d['apply_time'])){
            list($apply_start,$apply_end) = explode('~', $d['apply_time']);
            $whereData['apply_start'] = $apply_start;
            $whereData['apply_end'] = $apply_end;
            $whereData['apply_time'] = $d['apply_time'];
        }else{
            $whereData['apply_time'] = '';
        }

        if(!empty($d['repayment_time'])){
            list($repayment_start_t,$repayment_end_t) = explode('~', $d['repayment_time']);
            $whereData['repayment_start_t'] = $repayment_start_t;
            $whereData['repayment_end_t'] = $repayment_end_t;
            $whereData['repayment_time'] = $d['repayment_time'];
        }else{
            $whereData['repayment_time'] = '';
        }

        $whereData['nickname'] = !empty($d['nickname']) ? trim($d['nickname']) : '';
        $whereData['u_name'] = !empty($d['u_name']) ? trim($d['u_name']) : '';
        $whereData['borrow_start'] = !empty($d['borrow_start']) ? trim($d['borrow_start']) : '';
        $whereData['borrow_end'] = !empty($d['borrow_end']) ? trim($d['borrow_end']) : '';
        $whereData['repayment_start'] = !empty($d['repayment_start']) ? trim($d['repayment_start']) : '';
        $whereData['repayment_end'] = !empty($d['repayment_end']) ? trim($d['repayment_end']) : '';

        return $whereData;
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
    public function show($id)
    {
        //
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
        // 删除借款列表 和 借款账单??
        if(!$this->borrowApply->CommonDelete($id)){
            return JsonResponse::JsonData(ApiErrDesc::BORROWAPPLY_DELETE_FAIL[0],ApiErrDesc::BORROWAPPLY_DELETE_FAIL[1]);
        } 
        return JsonResponse::ResponseSuccess();
    }
}
