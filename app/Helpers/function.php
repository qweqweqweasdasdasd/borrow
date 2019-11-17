<?php 

/**
 *	公共方法--修改状态
 */
function common_reset_status($status)
{
	switch ($status) {
		case '1':
			return '<button type="button" class="layui-btn layui-btn layui-btn-xs reset" status="2">停用</button>';
		case '2':
			return '<button type="button" class="layui-btn layui-btn-warm layui-btn-xs reset" status="1">启用</button>';
	}
}

/**
 *	公共方法--显示状态
 */
function common_show_status($status,$t1,$t2)
{
	switch ($status) {
		case '1':
			return '<span class="layui-badge layui-bg-green">'.$t1.'</span>';
		case '2':
			return '<span class="layui-badge">'.$t2.'</span>';
	}
}

/**
 *  显示-信用分类
 */
function show_credit_cate($cateId)
{
    switch ($cateId) {
        case '1':
            return '电子信用额度';
        case '2';
            return '真人信用额度';
    }
}

/**
 *  账单状态
 *  1,待申请 2,借款成功 3,借款失败 4,待还款 5,还款成功 6,还款失败
 */
function bill_show_status($status)
{
    switch ($status) {
        case '1':
            return '<span class="layui-badge layui-bg-blue">待申请</span>';
        case '2':
            return '<span class="layui-badge layui-bg-green">借款成功</span>';
        case '3':
            return '<span class="layui-badge">借款失败</span>';
        case '4':
            return '<span class="layui-badge layui-bg-blue">待还款</span>';
        case '5':
            return '<span class="layui-badge layui-bg-green">还款成功</span>';
        case '6':
            return '<span class="layui-badge">还款失败</span>';
    }
}


/**
 * 递归方式获取上下级权限信息
 */
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['ps_id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['pid']])){
            $items[$item['pid']]['son'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return getTreeData($tree);
}
function getTreeData($tree,$level=0){
    static $arr = array();
    foreach($tree as $t){
        $tmp = $t;
        unset($tmp['son']);
        //$tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}
/**
 * PHP 递归无限极分类
 */
function GetTree($array,$pid=0,$level=0)
{
   // 声明静态数组,避免递归多次调用的时候,数据覆盖
   static $list = [];
   foreach ($array as $k => $v) {
      // 第一次遍历,找到pid = 0的所有节点
      if($v['pid'] == $pid){
            // 保存级别
            //$v['lev'] = $level;
            // 把符合条件的数组放到list
            $list[] = $v;
            // 把这个节点删除,减少递归消耗
            unset($array[$k]);
            // 开始递归,查找父id为该节点id的节点,级别设置为1
            GetTree($array,$v['rule_id'],$level+1);
      } 
   }
   return $list;
}

/**
 * 获取当前控制器名
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}
/**
 * 获取当前方法名
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}
/**
 * 获取当前控制器与操作方法的通用函数
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    //dd($action);exit;
    //dd($action);
    list($class, $method) = explode('@', $action);
    //$classes = explode(DIRECTORY_SEPARATOR,$class);
    $class = str_replace('Controller','',substr(strrchr($class,'\\'),1));
    return ['controller' => $class, 'method' => $method];
}