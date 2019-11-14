<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Response\JsonResponse;
use App\ErrDesc\ApiErrDesc;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /**
         *  admin 路由
         */ 
        //if($request->is('admin/*')){
            if($exception instanceof ValidationException){
                $result = [
                    "code" => ApiErrDesc::FORM_ERR[0],
                    "msg"  => implode('|',array_collapse($exception->errors()))
                ];
                
                //return JsonResponse::JsonData($result['code'],$result['msg']);
                return response()->json($result);
            }
        //}
        return parent::render($request, $exception);
    }
}
