<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JiekuanRequest extends FormRequest
{
     /**
     *  验证的字段
     */
    protected $rules = [
        'userAccount' => 'required|max:20',
        'userName' => 'required|max:8',
        'amount' => 'required|numeric',
        'hk_time' => 'required|date',
    ];

    /**
     *  自定义错误信息
     */
    protected $messages = [
        'userAccount.required' => '会员账号必须填写!',
        'userAccount.max' => '会员账号不得超出20个字符!',

        'userName.required' => '真实姓名必须填写!',
        'userName.max' => '真实姓名不得超出8个字符!',
        
        'amount.required' => '借款金额必须填写!',
        'amount.numeric' => '借款金额格式不符',

        'hk_time.required' => '还款日期必须填写!',
        'hk_time.date' => '还款日期格式不符!',
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
     
        return $rules;
    }

    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
