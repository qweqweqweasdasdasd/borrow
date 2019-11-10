<?php
namespace App\Repositories;

use App\Member;

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
     *  获取用户信息
     */
    public function Members()
    {
        
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