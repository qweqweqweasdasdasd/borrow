<?php
namespace App\Repositories;

use Illuminate\Container\Container as App;

class BaseRepository 
{
    /**
     *  容器
     */
    protected $app;

	/**
	 *	实例化模型
	 */
	protected $model;

    /**
     *  初始化模型
     */
    public function __construct()
    {
        $this->model = $this->common;
    }

    /**
     *	公共方法--保存数据
     */
    public function CommonSave($d)
    {
    	return $this->model::create($d);
    }

    /**
     *  公共方法--更新数据
     */
    public function CommonUpdate($id,$d)
    {
        return $this->model->where($this->primaryKey,$id)->update($d);
    }

    /**
     *  公共方法--删除指定数据
     */
    public function CommonDelete($id)
    {
        return $this->model->where($this->primaryKey,$id)->delete();
    }

    /**
     *  公共方法--获取到指定一条数据
     */
    public function GetOne($id)
    {
        return $this->model::find($id);
    }

    /**
     *  公共方式--修改状态
     */
    public function CommonSetStatus($id,$status)
    {   
        $data = [
            $this->status => $status
        ];
        return $this->model->where($this->primaryKey,$id)->update($data);
    }

    /**
     *  根据 父级id 生成层级
     */
    public function generateLevel($pid)
    {
        if($pid){
            return intval($this->model->where('ps_id',$pid)->first()->level + 1);
        }
        return 0;
    }

    /**
     *	公用方法--获取到当前pathInfo()
     */
    public function CommonPathInfo()
    {
    	return $this->getCurrentAction();
    }

    protected function getCurrentAction()
	{
	    $action = \Route::current()->getActionName();
	    list($class, $method) = explode('@', $action);
	    $data = explode('\\', $class);

	    $d = [
	    	'module' => strtolower($data[3]),
	    	'contr' => strtolower(str_replace('Controller', '', $data[4])),
	    	'method' => strtolower($method)
	    ]; 	
	   	
	    return $d;
	}

}