<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use App\Rules\Telphone;

class LoginRequest extends FormRequest {

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
            'telphone' => 'required|telphone|exists:users',
            'password' => 'required|between:6,18',
        ];
    }

    public function messages() {
        return [
            'telphone.required' => '请填写手机号码',
            'telphone.exists' => '该手机号码未注册',
            'password.required' => '请填写密码',
            'password.between' => '密码为6~18位',
        ];
    }

}
