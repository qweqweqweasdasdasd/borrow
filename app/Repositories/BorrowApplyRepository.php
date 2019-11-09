<?php
namespace App\Repositories;

use App\BorrowApply;

class BorrowApplyRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $borrowApply;

    /**
     *  状态字段
     */
    public $status = 'status';

    /**
     *  主键字段
     */
    public $primaryKey = 'ba_id';

    /**
     * 	初始化模型
     */
    public function __construct(BorrowApply $borrowApply)
    {
        $this->borrowApply = $borrowApply;
        $this->common = $borrowApply;
        parent::__construct();
    }
  	
    /**
     *  借款列表
     */
    public function borrowApplys($d)
    {
        $list = $this->borrowApply::orderBy('ba_id','desc');

        //  查询会员账号
        if(!empty($d['nickname'])){
            $list->where('nickname',$d['nickname']);
        }
        //  查询真实姓名
        if(!empty($d['u_name'])){
            $list->where('u_name',$d['u_name']);
        }
        // 借款总额
        if(!empty($d['borrow_start']) && !empty($d['borrow_end']) && $d['borrow_end'] > $d['borrow_start']){
            $list->whereBetween('borrow_total_money',[$d['borrow_start'],$d['borrow_end']]);
        }
        // 还款总额
        if(!empty($d['repayment_start']) && !empty($d['repayment_end']) && $d['repayment_end'] > $d['repayment_start']){
            $list->whereBetween('repayment_total_money',[$d['repayment_start'],$d['repayment_end']]);
        }
        // 申请时间
        if(!empty($d['apply_time'])){
            $list->whereBetween('apply_time',[$d['apply_start'],$d['apply_end']]);
        }
        // 还款时间
        if(!empty($d['repayment_time'])){
            $list->whereBetween('repayment_time',[$d['repayment_start_t'],$d['repayment_end_t']]);
        }

        return $list->paginate(9);
    }
}