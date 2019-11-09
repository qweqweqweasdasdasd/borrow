<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ManagerRequest extends FormRequest
{
    /**
     *  验证的字段
     */
    protected $rules = [
        'mg_name' => 'required|max:10|unique:manager',
        'password' => 'required|max:150|confirmed',
        'mg_status' => 'required|in:1,2',
        'email' => 'required|email',
    ];

    /**
     *  自定义错误信息
     */
    protected $messages = [
        'mg_name.required' => '管理员名称必须填写!',
        'mg_name.max' => '管理员名称不得超出10个字符!',
        'mg_name.unique' => '管理员名称不得重复!',
        'password.required' => '密码必须填写!',
        'password.confirmed' => '输入密码和确认密码不一致!',
        'password.max' => '密码不得超出150个字符!',
        'mg_status.required' => '管理员状态必须填写!',
        'mg_status.in' => '管理员状态格式不对!',
        'email.required' => '邮箱必须填写!',
        'email.email' => '邮箱格式不符!',
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
            $rules['mg_name'] = 'required|max:10';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
