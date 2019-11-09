<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowBill extends Model
{
    protected $primaryKey = 'bd_id';
	protected $table = 'borrow_bill';
    protected $fillable = [
    	'u_name','apply_time','repayment_time','update_time','borrow_money','status','ba_id'
    ];

}
