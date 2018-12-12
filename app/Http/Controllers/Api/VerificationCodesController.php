<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\SmsRegisterRequest;
use App\Services\VerificationCode;

class VerificationCodesController extends BaseController {

    //注册验证码
    public function store(SmsRegisterRequest $request) {
        $telphone = $request->telphone;
        $response = VerificationCode::send($telphone,'register');
        return $this->response->array($response)->setStatusCode(201);
    }

}
