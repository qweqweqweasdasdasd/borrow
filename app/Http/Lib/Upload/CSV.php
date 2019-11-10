<?php
namespace App\Lib\Upload;

/**
 * 上传csv
 */
class CSV extends Base
{
	/**
	 *	上传类型
	 */
	protected $type = 'csv';

	/**
	 *	上传文件大小
	 */
	protected $maxSize = 83886080;	//80M

	/**
	 *	文件后缀
	 */
	protected $fileExt = [
		'xls',
		'csv'
	];

	/**
	 *	移动到指定的位置
	 */
	public function moveTo()
	{	
		$dir = "upload/{$this->type}";
		if(!is_dir($dir)){
			mkdir($dir,0777,true);
		}
		$filename = '/import.' . $this->ext;
		$this->pathinfo = $dir . $filename;
		//dd($this->pathinfo);
		$this->upload->move($dir,$this->pathinfo);
	}

}