<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class RegisterRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'code' => 'required',
            'password' => 'required|between:6,18',
            'telphone' => 'required|telphone|unique:users',
        ];
    }

    public function messages() {
        return [
            'telphone.required' => '请填写手机号码',
            'telphone.unique' => '该手机号码已经被注册',
            'code.required' => '请填写验证码',
            'password.required' => '请填写密码',
            'password.between' => '密码为6~18位',
        ];
    }

}
