<?php 
namespace App\Lib\Read;

/**
 * 从文件内读取数据写到数据库内
 */
class CSV
{
	/**
	 *	文件路径
	 */
	protected $filePath = '';

	/**
	 *	初始化参数
	 */
	public function __construct($path = null)
	{
		if(!empty($path)){
			$this->filePath = $path;
		}
	}

	/** 
	 *	读取文件
	 */
	public function read()
	{
		set_time_limit(0);
		ignore_user_abort(true); //设置客户端断开连接时继续执行脚本
		ini_set('memory_limit','1024M');

		$handle = fopen($this->filePath, 'rb');
		// 将数据一次性读出来
		$excelData = [];
		while ($row = fgetcsv($handle,1000,',')) {
			$excelData[] = $row;
		}
		
		fclose($handle);
		return $excelData;
	}
}