<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('telphone', function($attribute, $value, $parameters) {
            return preg_match('/^1[0-9]{10}$/', $value);
        });

        //未登录返回401
        \API::error(function (\Illuminate\Auth\AuthenticationException $exception) {
            abort(401, '未登录或登录状态已过期');
        });
        //已经登录但是没有权限返回403
        \API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, '此操作未经授权。');
        });
        //没有找到资源返回404
        \API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404,'未找到资源');
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
