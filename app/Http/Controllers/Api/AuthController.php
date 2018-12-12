<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Auth;
use JWTAuth;
use App\Http\Transformers\UserTransformer;

class AuthController extends BaseController {

    public function register(RegisterRequest $request) {
        $input = $request->all();
        $smsCode = \Cache::get("verify_code.register.{$input['telphone']}");
        if ($input['code'] != $smsCode) {
            // 返回401
            return $this->response->errorUnauthorized('短信验证码错误');
        }

        $user = User::create([
                    'username' => $input['telphone'],
                    'telphone' => $input['telphone'],
                    'password' => bcrypt($input['password'])
        ]);

        //让验证码失效
        //\Cache::forget('captcha.' . $input['telphone']);
        \Cache::forget('sms_code.' . $input['telphone']);

        //自动登陆并返回token
        $token = $this->guard()->login($user, true);
        return $this->response->item($user, new UserTransformer())
                        ->setMeta($this->respondWithToken($token))
                        ->setStatusCode(201);
    }

    public function login(LoginRequest $request) {
        $credentials = [
            'telphone' => $request->telphone,
            'password' => $request->password,
        ];
        if (!$token = $this->guard()->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }
        return $this->response->item($this->guard()->user(), new UserTransformer())
                        ->setMeta($this->respondWithToken($token))
                        ->setStatusCode(201);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

}
