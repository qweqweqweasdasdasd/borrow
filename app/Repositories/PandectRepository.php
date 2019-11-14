<?php
namespace App\Repositories;

use App\Pandect;

class PandectRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $pandect;

    /**
     *  状态字段
     */
    public $status = 'status';

    /**
     *  主键字段
     */
    public $primaryKey = 'p_id';

    /**
     * 	初始化模型
     */
    public function __construct(Pandect $pandect)
    {
        $this->pandect = $pandect;
        $this->common = $pandect;
        parent::__construct();
    }

    /**
     *  获取到总览表数据
     */
    public function pandects($d)
    {
        $list = $this->pandect::leftJoin('member','pandect.m_id','=','member.m_id');
        //  查询会员账号
        if(!empty($d['userAccount'])){
            $list->where('userAccount',$d['userAccount']);
        }
        //  查询真实姓名
        /*if(!empty($d['u_name'])){
            $list->where('u_name',$d['u_name']);
        }*/
        // 借款总额
        if(!empty($d['borrow_start']) && !empty($d['borrow_end']) && $d['borrow_end'] > $d['borrow_start']){
            $list->whereBetween('borrow_total',[$d['borrow_start'],$d['borrow_end']]);
        }
        // 还款总额
        if(!empty($d['repayment_start']) && !empty($d['repayment_end']) && $d['repayment_end'] > $d['repayment_start']){
            $list->whereBetween('repayment_total',[$d['repayment_start'],$d['repayment_end']]);
        }


        return $list->paginate(13);
    }
    /**
     *	生成数据
     */
    public function store($data)
    {
    	return $this->pandect::create($data);
    }

    /**
     *  总览表更新
     */
    public function PandectUpdate($m_id,$data)
    {
        $pandect = $this->PandByMemId($m_id);
        $pandect->debt = $pandect->debt+$data['amount'];
        $pandect->borrow_total = $pandect->borrow_total+$data['amount'];
        $pandect->total_count = ++$pandect->total_count;
        $pandect->save();
    }

    /**
     *  通过用户id获取到总览表
     */
    public function PandByMemId($id)
    {
        return $this->pandect::where('m_id',$id)->first();
    }
  	
}