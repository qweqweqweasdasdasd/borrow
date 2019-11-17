<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreditRequest extends FormRequest
{
    /**
     *  验证的字段
     */
    protected $rules = [
        'cate_id' => 'required|numeric',
        'credit_name' => 'required|max:10',

        'month_salary' => 'required|numeric',
        'amount' => 'required|numeric',
    ];

    /**
     *  自定义错误信息
     */
    protected $messages = [
        'cate_id.required' => '分类必须选择!',
        'cate_id.numeric' => '分类格式不对!',

        'credit_name.required' => '信用等级名必须填写!',
        'credit_name.max' => '信用等级不对超出10个字符!',
        
        'week_salary.required' => '周俸禄必须填写!',
        'week_salary.numeric' => '周俸禄格式不对!',

        'month_salary.required' => '月俸禄必须填写!',
        'month_salary.numeric' => '月俸禄格式不对!',

        'amount.required' => '信用额度必须填写!',
        'amount.numeric' => '信用额度格式不对!',

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
