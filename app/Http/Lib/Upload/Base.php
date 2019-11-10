<?php 
namespace App\Lib\Upload;

/**
 * 上传csv
 */
class Base
{
	/**
	 *	request 对象
	 */
	protected $request = '';

	/**
	 *	上传文件类型
	 */
	protected $key = '';

	/**
	 *	上传文档对象
	 */
	protected $upload = '';

	/**
	 *	判断文件类型
	 */
	public function __construct($request,$type = null)
	{
		$this->request = $request;
		if(empty($type)){
			$this->key = array_keys($this->request->file())[0];
		}
		$this->key = $type;
	}

	/**
	 *	上传操作
	 */
	public function upload()
	{
		if($this->key != $this->type){
			return 0;
		}
		$this->upload = $this->request->file($this->key);
		
		if(!$this->upload->isValid()){
			throw new \Exception("不是一个有效的文件");
		}
		// 上传文件类型核对
		$this->checkExtension();
		// 上传文件大小核对
		$this->checkSize();
		// 移动到指定的位置
		$this->moveTo();
		// 写入服务器
		return $this->pathinfo;
	}

	/**
	 *	移动到指定的位置
	 */
	public function moveTo()
	{	
		$dir = "upload/{$this->type}/" . date('m') . '/' . date('d');
		if(!is_dir($dir)){
			mkdir($dir,0777,true);
		}
		$filename = '/'. date('YmdHis',time()) . '.' . $this->ext;
		$this->pathinfo = $dir . $filename;
		//dd($this->pathinfo);
		$this->upload->move($dir,$this->pathinfo);
	}

	/**
	 *	上传文件大小
	 */
	public function checkSize()
	{
		$this->size = $this->upload->getClientSize();
		if($this->size > $this->maxSize){
			throw new \Exception("上传文件大小不得超出{$this->maxSize}kb");
		}
	}

	/**
	 *	上传文件类型核对
	 */
	public function checkExtension()
	{
		//$clientMimeType = explode('/',$this->upload->getClientMimeType());
		$this->ext = ($this->upload->getClientOriginalExtension());
		if(empty($this->ext)){
			throw new \Exception("上传文件{$this->ext}不合法!");
		}
		if(!in_array($this->ext, $this->fileExt)){
			throw new \Exception("上传文件后缀{$this->ext}不在允许的数组内!");
		}
	}
}