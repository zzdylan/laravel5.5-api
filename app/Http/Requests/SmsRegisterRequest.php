<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use App\Rules\Telphone;

class SmsRegisterRequest extends FormRequest {

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
            'telphone' => 'required|telphone|unique:users'
        ];
    }

    public function messages() {
        return [
            'telphone.required' => '请填写手机号码',
            'telphone.unique' => '手机号码已被注册'
        ];
        ;
    }

}
