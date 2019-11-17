<?php
namespace App\Repositories;

use App\Credit;

class CreditRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $credit;

    /**
     *  状态字段
     */
    public $status = 'status';

    /**
     *  主键字段
     */
    public $primaryKey = 'c_id';

    /**
     * 	初始化模型
     */
    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
        $this->common = $credit;
        parent::__construct();
    }

  	/**
  	 *	信用获取所有数据
  	 */
  	public function credits($d)
  	{
      $list = $this->credit::orderBy('c_id','asc');
      if(!empty($d['cate_id'])){
        $list->where('cate_id',$d['cate_id']);
      }
      return $list->paginate(10);
  	}
}