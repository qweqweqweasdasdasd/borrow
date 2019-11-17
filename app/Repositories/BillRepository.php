<?php
namespace App\Repositories;

use App\Bill;

class BillRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $bill;

    /**
     *  状态字段
     */
    public $status = 'status';

    /**
     *  主键字段
     */
    public $primaryKey = 'b_id';

    /**
     * 	初始化模型
     */
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
        $this->common = $bill;
        parent::__construct();
    }

    /**
     *	存储账单数据
     */
    public function store($d)
    {
    	return Bill::create($d);
    }

    /**
     *  获取到bill所有数据
     */
    public function bills($d = null)
    {
        $list = $this->bill::with('pandect')->orderBy('b_id','desc');

        // 会员账号
        if(!empty($d['userAccount'])){
            $list->where('userAccount',$d['userAccount']);
        }

        // 借款总额
        if(!empty($d['borrow_start']) && !empty($d['borrow_end']) && $d['borrow_end'] > $d['borrow_start']){
            $list->whereBetween('borrow_money',[$d['borrow_start'],$d['borrow_end']]);
        }

        // 账单状态
        if(!empty($d['status'])){
            $list->where('status',$d['status']);
        }

        return $list->paginate(13);
    }

    /**
     *  获取到还款所有数据
     */
    public function hkbills($d)
    {
        $list = $this->bill::with('pandect')->orderBy('b_id','desc');
        
        // 会员账号
        if(!empty($d['userAccount'])){
            $list->where('userAccount',$d['userAccount']);
        }

        // 借款总额
        if(!empty($d['borrow_start']) && !empty($d['borrow_end']) && $d['borrow_end'] > $d['borrow_start']){
            $list->whereBetween('borrow_money',[$d['borrow_start'],$d['borrow_end']]);
        }

        // 账单状态
        if(empty($d['status'])){
            $list->where('status','>',3);
        }else{
            $list->where('status',$d['status']);
        }

        return $list->paginate(13);
    }
  	
}