<?php

namespace App\Services;

use App\Services\Sms;

class VerificationCode
{
    /**
     * 发送手机验证码
     * @param $telphone 手机号码
     * @param $type 验证码类型
     * @param int $expiredTime 有效时间 单位分钟
     * @return mixed
     */
    public static function send($telphone,$type,$expiredTime=10){
        $sms = new Sms();
        $expiredAt = now()->addMinutes($expiredTime);
        $response = [
            'telphone' => $telphone,
            'expired_at' => $expiredAt->toDateTimeString(),
        ];
        $verifyCode = generate_code();
        if (!config('sms.debug')) {
            $sms->send($telphone, [
                'content'  => "【陪伴成长】您的验证码是：{$verifyCode}",
            ]);
        } else {
            $response['verify_code'] = $verifyCode;
            \Log::info($verifyCode);
        }
        \Cache::put("verify_code.{$type}.{$telphone}", $verifyCode, $expiredAt);
        return $response;
    }

    public static function check($telphone,$code,$type){
        $verifyCode = \Cache::get("verify_code.{$type}.{$telphone}");
        if ($code == $verifyCode) {
            //让验证码失效
            \Cache::forget("verify_code.{$type}.{$telphone}");
            return true;
        }
        return false;
    }

}