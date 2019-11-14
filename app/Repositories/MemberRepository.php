<?php
namespace App\Repositories;

use App\Member;
use App\Vip;

class MemberRepository extends BaseRepository
{
	/**
	 *	管理员
	 */
	protected $member;

    /**
     *  状态字段
     */
    public $status = 'member_status';

    /**
     *  主键字段
     */
    public $primaryKey = 'm_id';

    /**
     * 	初始化模型
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
        $this->common = $member;
        parent::__construct();
    }

    /**
     *  保存数据
     */
    public function store($data,$balanced)
    {
        $data = [
            'userAccount' => $data['userAccount'],
            'userName' => !empty($data['userName'])?$data['userName']:'',
            'telephone' => $data['telephone'],
            'userId' => $data['userId'],
            'vip_id' => $this->transformToVipId($data['vipName']),
            'update_vip_time' => date('Y-m-d H:i:s',time()),
            'balanced' => $balanced,
        ];

        return $this->member::create($data);
    }

    /**
     *  vip等级转换为id
     */
    public function transformToVipId($vipName)
    {
        $vips = Vip::get(['vip_id','vipName']);
        foreach ($vips as $k => $v) {
            if($v->vipName == strtolower($vipName)){
                return $v->vip_id;
            }
        }
    }

    /**
     *  通过id获取到vipName
     */
    public function transformToVipName($vip_id)
    {
        $vips = Vip::get(['vip_id','vipName']);
        foreach ($vips as $k => $v) {
            if($v->vip_id == $vip_id){
                return strtolower($v->vipName);
            }
        }
    }
    /**
     *  获取到指定的数据
     */
    public function getOneWithVipBy($userAccount)
    {
        return $this->member::with('vip')->where('userAccount',$userAccount)->first();
    }

    /** 
     *  获取用户信息
     */
    public function Members($d)
    {
        $list = $this->member::with(['vip'=>function($query){
                $query->select('vip_id','vipName');
            }])
            ->orderBy('m_id','desc');
        // 查询会员账号
        if(!empty($d['userAccount'])){
            $list->where('userAccount',$d['userAccount']);
        }
        // 查询真实姓名
        if(!empty($d['userName'])){
            $list->where('userName',$d['userName']);
        }
        // 查询手机号
        if(!empty($d['telephone'])){
            $list->where('telephone',$d['telephone']);
        }
        return $list->paginate(9);
    }

    /**
     *  转换为 sql 插入数据库
     */
    public function transitionMemberToSql($data)
    {
        // 切为
        $chunckData = array_chunk($data, 1000);    // 分割为1000小数组
        if(count($chunckData) > 100){
            throw new \Exception("导入数据不得超出1万");
        }
        $count = count($chunckData);
        
        for ($i=0; $i < $count; $i++) { 
            $var = [];
            foreach ($chunckData[$i] as $v) {
                $userAccount = mb_convert_encoding($v[0],'UTF-8','GBK');    // 会员账号
                $telephone = !empty($v[1])?$v[1]:'';    // 手机号码
                $vipName = mb_convert_encoding($v[2],'UTF-8','GBK');    // vip等级
                $userName = mb_convert_encoding($v[3],'UTF-8','GBK');    // 真实姓名
                $userId = !empty($v[4])?$v[4]:'';    // userid 后台

                if(!preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$userAccount)){  // 判断是否为汉字
                    $str = "('{$userAccount}','{$telephone}','{$vipName}','{$userName}','{$userId}')";
                    $var[] = $str;
                }
            }
            $data = implode(',', $var);
            
            // 导入数据库
            $this->member->WriteMysql($data);
        }

        return true;
    }
}