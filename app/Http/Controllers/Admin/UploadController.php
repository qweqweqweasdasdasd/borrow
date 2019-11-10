<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use App\Response\JsonResponse;
use App\Lib\ClassMap;
use App\Lib\Upload\CSV;
use App\Lib\Read\CSV as ReadCSV;
use Illuminate\Http\Request;
use App\Jobs\fromCsvToDBJob;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class UploadController extends Controller
{
	/**
	 *	仓库对象
	 */
	protected $member;

	/**
	 * 	初始化仓库
	 */
	public function __construct(MemberRepository $member)
	{
		$this->member = $member;
	}
	
    /**
     *	上传文件使用 反射机制 实例化对象
     */
    public function upload(Request $request)
    {
    	$type = array_keys($request->file())[0];

    	$classObj = new ClassMap();
    	$supportedClass = $classObj->classStat();
    	try {
    		$obj = $classObj->initClass($type,$supportedClass,[$request,$type]);
    		$path = $obj->upload(); 
	    	//	读取文件
	    	$this->writeTo($type);
    	} catch (\Exception $e) {
    		return JsonResponse::JsonData(ApiErrDesc::CODE_ERR[0],$e->getMessage());
    	}
    	return JsonResponse::ResponseSuccess(['path'=>$path]);
    }

    /**
     *	写入数据库
     */
    public function writeTo($type)
    {
    	if($type == 'csv'){
    		$data = (new ReadCSV('upload/csv/import.csv'))->read();
    		$this->member->transitionMemberToSql($data);
    	}
    }
}
