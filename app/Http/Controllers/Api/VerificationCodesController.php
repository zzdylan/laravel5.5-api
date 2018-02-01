<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\SmsRegisterRequest;

class VerificationCodesController extends BaseController {

    //注册验证码
    public function store(SmsRegisterRequest $request) {
        $telphone = $request->telphone;
        $smsCode = generate_code();
        $res = sendSmsCode($telphone, $smsCode);
        if (!$res['status']) {
            return $this->response->errorInternal($res['msg'] ?? '短信发送异常');
        }
        $expiredAt = now()->addMinutes(10);
        \Cache::put('sms_code.' . $telphone, $smsCode, $expiredAt);
        return $this->response->array([
                    'telphone' => $telphone,
                    'expired_at' => $expiredAt->toDateTimeString(),
                ])->setStatusCode(201);
    }

}
