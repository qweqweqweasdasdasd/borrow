<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class VipRequest extends FormRequest
{

    /**
     *  验证的字段
     */
    protected $rules = [
        'vipName' => 'required|max:12|unique:vip_level',
        'borrow_balance' => 'required|numeric',
        'vip_status' => 'required|in:1,2',
    ];

    /**
     *  自定义错误信息
     */
    protected $messages = [
        'vipName.required' => 'vip名称必须填写',
        'vipName.max' => 'vip名称不得超出12个字符!',
        'vipName.unique' => 'vip名称重复了!',

        'borrow_balance.required' => '可借款金额必须填写!',
        'borrow_balance.numeric' => '可借金额格式不对!',
        
        'vip_status.required' => 'vip状态必须存在',
        'vip_status.in' => 'vip状态格式不对!',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        
        if(Request::isMethod('PATCH')){
            $rules['vipName'] = 'required|max:12';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
