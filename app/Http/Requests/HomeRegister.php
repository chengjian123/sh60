<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeRegister extends FormRequest
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
//    前台注册验证规则
    public function rules()
    {
        return [
            'name'=>'required',
            'password'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
//            'password_confirmation'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'昵称不能为空',
            'email.required'=>'邮箱不能为空',
            'email.unique'=>'邮箱已被注册',
            'email.email'=>'邮箱格式不正确',
            'password.required'=>'密码不能为空',
            'password.min'=>'密码不能少于3位',
/*            'password.confirmed'=>'两次密码不一致',
            'password_confirmation.required'=>'请确认密码',*/
        ];
    }
}
