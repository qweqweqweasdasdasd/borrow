<?php 
namespace App\Lib;

/**
 *	使用反射机制实例化对象 
 */
class ClassMap 
{	
	public function classStat()
	{
		return [
			'csv' => 'App\Lib\Upload\CSV',
		];
	}

	public function initClass($type,$supportedClass,$params=[],$needInstance=true)
	{
		if(!array_key_exists($type, $supportedClass)){
			throw new \Exception("配置错误");
		}
		$className = $supportedClass[$type];

		return $needInstance ? (new \ReflectionClass($className))->newInstanceArgs($params):$className;
	}
}