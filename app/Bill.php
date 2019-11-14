<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $primaryKey = 'b_id';
	protected $table = 'bill';
    protected $fillable = [
    	'userAccount','userName','vipName','apply_time','repayment_time','borrow_money','status','p_id'
    ];

    // 账单和总览 多对一关系
    public function pandect()
    {
    	return $this->belongsTo('App\Pandect','p_id','p_id');
    }
}
