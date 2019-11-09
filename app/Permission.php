<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'ps_id';
	protected $table = 'permission';
    protected $fillable = [
    	'ps_name','ps_c','ps_a','route','is_show','is_verfy','pid','level'
    ];

    //	
}
