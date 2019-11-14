<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pandect extends Model
{
    protected $primaryKey = 'p_id';
	protected $table = 'pandect';
    protected $fillable = [
    	'm_id','debt','borrow_total','repayment_total','total_count'
    ];

    /**
     *	总览表和用户表 一对一关系
     */
    public function member()
    {
    	return $this->hasOne('App\Member','m_id','m_id');
    }
}
