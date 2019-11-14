<?php

namespace App\Http\Controllers\Wap;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use App\Lib\Server\Platfrom;
use App\Lib\Server\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\JiekuanRequest;
use App\Repositories\MemberRepository;
use App\Repositories\PandectRepository;
use App\Repositories\BillRepository;
use App\Lib\Server\RedisServer;
use App\Lib\Server\UpdateVipInfo;

class JiekuanController extends Controller
{
    /**
     *  用户仓库
     */
    protected $member;

    /**
     *  总览仓库
     */
    protected $pandect;

    /**
     *  账单仓库
     */
    protected $bill;

    /**
     *  初始化数据
     */
    public function __construct(MemberRepository $member,PandectRepository $pandect,BillRepository $bill)
    {
        $this->member = $member;
        $this->pandect = $pandect;
        $this->bill = $bill;
    }
   
    /**
     *	首页
     */
    public function index()
    {
    	return view('wap.jiekuan.index');
    }

    /** 
     *	提交表单
     */
    public function submit(JiekuanRequest $request)
    {
        $data = [
            "userAccount" => !empty($request->get('userAccount'))?trim($request->get('userAccount')):'',
            "userName" => !empty($request->get('userName'))?trim($request->get('userName')):'',
            "amount" => !empty($request->get('amount'))?trim($request->get('amount')):'',
            "hk_time" => !empty($request->get('hk_time'))?trim($request->get('hk_time')):'',
        ];
        
        // 核实用户是否达到条件
        try {
            // 添加一层redis拦截
            $this->fiterUser($data);

            // 根据提交查询用户
            $this->mem = $this->member->getOneWithVipBy($data['userAccount']);

            if(!$this->mem){
                //  生成用户表和总览表
                $this->createMemberPandect($data);
                // 检查金额
                $account = (new Account)->setParam($data)->Verify($this->mem);
            }else{
                // 检查金额
                $account = (new Account)->setParam($data)->Verify($this->mem);
                //  更新用户表和总览表
                $this->UpdateMemberPandect($data);
            }

            
            $this->vipName = $this->member->transformToVipName($this->mem->vip_id); 
            $this->pande = $this->pandect->PandByMemId($this->mem->m_id);
            // 生成账单
            $d = [
                'userAccount' => $this->mem->userAccount,
                'userName' => $data['userName'],
                'vipName' => $this->vipName,
                'apply_time' => date('Y-m-d H:i:s',time()),
                'repayment_time' => $data['hk_time'],
                'borrow_money' => $data['amount'],
                'status' => 1,
                'p_id' => $this->pande->p_id, 
            ];

            // 详细账单
            $this->bill->store($d);

            // 记录到redis
            (new RedisServer)->addAccountToApplyStatusList($d['userAccount']);
        } catch (\Exception $e) {
            return JsonResponse::JsonData(ApiErrDesc::CODE_ERR[0],$e->getMessage());
        }
        $d = [
            'msg' => $data['userAccount'].'申请成功!',
        ];
        return JsonResponse::ResponseSuccess($d);
    }

    /**
     *  添加一层redis拦截
     */
    public function fiterUser($data)
    {
        // 过滤非平台用户(redis集合)
        (new RedisServer)->existPlatformValue($data['userAccount']);
    }

    /**
     *  生成详情账单 || 更新用户表 || 更新总览表
     */
    public function UpdateMemberPandect($data)
    {
        // 开启事务
        \DB::beginTransaction();
        try { 
            // 更新用户已借款金额
            $this->mem->balanced = ($this->mem->balanced + $data['amount']);
            $this->mem->save();
            // 总览表更新
            $this->pandect->PandectUpdate($this->mem->m_id,$data);
            // 提交
            \DB::commit();
        } catch (\Exception $e) {
            // 回滚
            \DB::rollBack();
        }

    }

    /** 
     *  生成用户表和总览表
     */
    public function createMemberPandect($data)
    {
        // $res = (new Platfrom)->setParam($data)->FromPlatfromPull();  

        // // 平台无该用户 || 令牌过期
        // if($res['code'] == 100 || $res['code'] == 101){
        //     throw new \Exception($res['msg']);
        // }

        // if($res['code'] == 200){
        //     $this->response = $res['data'];
        // }
        
        $this->response = (new UpdateVipInfo)->GetPlalformParam($data);

        // 开启事务
        \DB::beginTransaction(); 
        try {
            
            // 生成用户表
            $this->mem = $this->member->store($this->response,$data['amount']);

            // 生成总览表
            $d = [
                'm_id' => $this->mem->m_id,
                'debt' => $data['amount'],
                'borrow_total' => $data['amount'],
                'total_count' => 1,
            ];
            $this->pande = $this->pandect->store($d);
            // 提交
            \DB::commit();
        } catch (\Exception $e) {
            // 回滚
            \DB::rollBack();
        }
    }

}
