<?php
namespace App\Repositories;

use App\Vip;

class VipRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $vip;

    /**
     *  状态字段
     */
    public $status = 'vip_status';

    /**
     *  主键字段
     */
    public $primaryKey = 'vip_id';

    /**
     * 	初始化模型
     */
    public function __construct(Vip $vip)
    {
        $this->vip = $vip;
        $this->common = $vip;
        parent::__construct();
    }

    /**
     *	vip获取所有数据
     */
    public function vips($d)
    {
    	$list = $this->vip::with('member')
            ->orderBy('vip_id','desc');

        // 根据关键字
        if(!empty($d['vipName'])){
            $list->where('vipName',strtolower($d['vipName']));
        }
        
        // 根据时间查询
        if(!empty($d['start']) && !empty($d['end'])){
            $list->whereBetween('created_at',[$d['start'],$d['end']] );
        }

    	return $list->paginate(13);
    }
  	
}