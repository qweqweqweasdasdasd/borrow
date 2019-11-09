<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerLoginRequest extends FormRequest
{
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
        return [
            'mg_name'  => 'required|max:10',
            'password'  => 'required|max:150',
        ];
    }

    public function messages()
    {
        return [
            'mg_name.required'  => '管理员必须填写!',
            'mg_name.max'  => '管理员名称不得超出10个字符!',
        
            'password.required'  => '管理员密码必须填写!',
            'password.max'  => '管理员密码不得超出150个字符!',
        ];
    }
}
