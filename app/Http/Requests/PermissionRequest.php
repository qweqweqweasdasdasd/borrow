<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     *  验证的字段
     */
    protected $rules = [
        'ps_name' => 'required|max:200|unique:permission',
        'ps_c'  => 'required|max:100',
        'ps_a'  => 'required|max:100',
        'route'  => 'required|max:100',
        'is_show'  => 'required|in:1,2',
        'is_verfy'  => 'required|in:1,2',
    ];

    /**
     *  自定义错误信息
     */
    protected $messages = [
        'ps_name.required' => '权限名称必须填写!',
        'ps_name.max' => '权限名称不得超出200个字符!',
        'ps_name.unique' => '权限名称不得重复!',

        'ps_c.required'  => '控制器名称必须填写!',
        'ps_c.max'  => '控制器不超出100个字符!',
        
        'ps_a.required'  => '方法名必须填写!',
        'ps_a.max'  => '方法名不得超出100个字符!',
        
        'route.required'  => '路由必须填写!',
        'route.max'  => '路由不得超出100个字符!',
        
        'is_show.required'  => '是否显示必须选择!',
        'is_show.in'  => '是否显示格式不对!',
        
        'is_verfy.required'  => '验证必须选择!',
        'is_verfy.in'  => '是否验证格式不对!',
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

        // pid 为零是顶级权限
        if(!Request::get('pid')){
            $rules['ps_c']  = '';
            $rules['ps_a']  = '';
            $rules['route']  = '';
        }
        if(Request::isMethod('PATCH')){
            $rules['ps_name'] = 'required|max:200';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}
