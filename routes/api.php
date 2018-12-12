<?php

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['middleware' => ['serializer:array'], 'namespace' => 'App\Http\Controllers\Api'], function ($api) {
    #公共模块
    $api->group(['prefix' => 'common','namespace' => 'Common'], function ($api) {
        #获取图形验证码
        $api->get('/captchas', ['uses' => 'CaptchasController@store']);
    });

    #发送短信验证码
    $api->post('/send_sms_code', ['uses' => 'VerificationCodesController@store']);
    #用户注册接口
    $api->post('/register', ['uses' => 'AuthController@register']);
    #用户登录接口
    $api->post('/login', ['uses' => 'AuthController@login']);
    $api->group(['middleware' => ['auth:api']], function ($api) {
        #获取用户个人信息
        $api->post('/me', ['uses' => 'UserController@me']);
    });
});
