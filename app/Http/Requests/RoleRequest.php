<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest
{
    /**
     *  验证的字段
     */
    protected $rules = [
        'role_name' => 'required|max:20|unique:role',
        'role_status' => 'required|in:1,2',
        'desc' => 'max:250',
    ];

    /**
     *  自定义错误信息
     */
    protected $messages = [
        'role_name.required' => '角色名称必须填写!',
        'role_name.max' => '角色名称不得超出20个字符!',
        'role_name.unique' => '角色名称不得重复!',
        'role_status.required' => '角色状态必须填写!',
        'role_status.in' => '角色状态格式不对!',
        'desc.max' => '角色描述不得超出250个字符!',
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
            $rules['role_name'] = 'required|max:10';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
