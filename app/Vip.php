<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vip extends Model
{
    protected $primaryKey = 'vip_id';
	protected $table = 'vip_level';
    protected $fillable = [
    	'vipName','borrow_balance','vip_status'
    ];


    /**
     *  vip和用户关系一对一
     */
    public function member()
    {
        return $this->hasMany('App\Member','vip_id','vip_id');
    }
}
