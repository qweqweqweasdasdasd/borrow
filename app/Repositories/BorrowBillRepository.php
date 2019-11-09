<?php
namespace App\Repositories;

use App\BorrowBill;

class BorrowBillRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $borrowBill;

    /**
     *  状态字段
     */
    public $status = 'status';

    /**
     *  主键字段
     */
    public $primaryKey = 'bd_id';

    /**
     * 	初始化模型
     */
    public function __construct(BorrowBill $borrowBill)
    {
        $this->borrowBill = $borrowBill;
        $this->common = $borrowBill;
        parent::__construct();
    }
  	
}