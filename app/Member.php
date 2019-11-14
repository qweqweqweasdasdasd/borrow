<?php

namespace App;

use App\Vip;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'm_id';
	protected $table = 'member';
    protected $fillable = [
    	'userAccount','userName','telephone','password','userId','vip_id','balanced','update_vip_time'
    ];

    /**
     *	批量插入数据库  [不使用]
     */
    public function WriteMysql($data)
    {
    	return \DB::insert(" INSERT INTO {$this->table} (`userAccount`,`telephone`,`vipName`,`userName`,`userId`) VALUES {$data}");
    }

    
    /**
     *  用户和vip关系一对一
     */
    public function vip()
    {
        return $this->hasOne('App\Vip','vip_id','vip_id');
    }

    public function transformToVipId($vipName)
    {
        $vips = Vip::get(['vip_id','vipName']);
        foreach ($vips as $k => $v) {
            if($v->vipName == strtolower($vipName)){
                return $v->vip_id;
            }
        }
    }
}
