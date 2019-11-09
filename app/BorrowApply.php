<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowApply extends Model
{
    protected $primaryKey = 'ba_id';
	protected $table = 'borrow_apply';
    protected $fillable = [
    	'user_id','u_name','me_limit','apply_time','repayment_time','borrow_total_money','repayment_total_money','arrearage','total_count','desc'
    ];


    // 借款申请和借款详情关系 一对多
    public function borrowBill()
    {
    	
    }
}
