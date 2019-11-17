<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $primaryKey = 'c_id';
	protected $table = 'credit';
    protected $fillable = [
    	'cate_id','credit_name','week_salary','month_salary','amount'
    ];

}
