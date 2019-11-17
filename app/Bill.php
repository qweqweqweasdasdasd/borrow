<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pandect;
use App\Member;

class Bill extends Model
{
    protected $primaryKey = 'b_id';
	protected $table = 'bill';
    protected $fillable = [
    	'userAccount','userName','vipName','apply_time','repayment_time','borrow_money','status','p_id','desc'
    ];

    // 账单和总览 多对一关系
    public function pandect()
    {
    	return $this->belongsTo('App\Pandect','p_id','p_id');
    }

    /**
     *  账单明细
     *  借款成功
     */
    public function PointSuccess($d,$id)
    { 
        $data = [
            'status' =>2,
            'desc' => $d['note']
        ];
        return $this->where('b_id',$id)->update($data);
    }

    /**
     *  账单明细
     *  还款成功
     */
    public function subtractPointSuccess($d,$id)
    {
        $data = [
            'status' =>5,
            'desc' => $d['note']
        ];
        // 用户表减去已经借款金额
        $member = Member::where('userAccount',$d['userAccount'])->first();
        $member->balanced = ($member->balanced - $d['balance']);
        $member->save();
        //dd($member);
        // 总览表加上还款总额
        $pandect = Pandect::where('m_id',$member->m_id)->first();
        $pandect->repayment_total = ($pandect->repayment_total + $d['balance']);
        $pandect->save();
        // 账单明细
        return $this->where('b_id',$id)->update($data);
    }

    /**
     *  借款失败,,重新提交
     */
    public function PointFail($d,$id)
    {
        // 详细账单修改状态备注信息
        $data = [
            'status' => 3,
            'desc' => $d['userAccount'] . '-money:' . $d['balance'] . '-borrow:fail',
        ];
        $this->where('b_id',$id)->update($data);
        // 用户表减去已经借款金额
        $member = Member::where('userAccount',$d['userAccount'])->first();
        $member->balanced = ($member->balanced - $d['balance']);
        $member->save();
        // 总览减去次数 && 减去借款总额
        $pandect = Pandect::where('m_id',$member->m_id)->first();
        $pandect->borrow_total = ($pandect->borrow_total - $d['balance']);
        $pandect->total_count = ($pandect->total_count-1);
        $pandect->save();
    }
}
