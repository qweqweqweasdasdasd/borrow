<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'm_id';
	protected $table = 'member';
    protected $fillable = [
    	'userAccount','password','telephone','vipName','userName','userId'
    ];

    /**
     *	批量插入数据库
     */
    public function WriteMysql($data)
    {
    	return \DB::insert(" INSERT INTO {$this->table} (`userAccount`,`telephone`,`vipName`,`userName`,`userId`) VALUES {$data}");
    }
}
