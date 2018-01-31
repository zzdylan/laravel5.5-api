<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject {

    use Notifiable;
//    use SoftDeletes;

    protected $guard_name = 'api';
    protected $table = 'users';
    protected $fillable = ['telphone', 'username', 'email', 'password', 'avatar', 'status'];
    protected $dates = ['deleted_at'];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function getAvatarAttribute($value) {
        return $value ? asset($value) : asset('images/default_avatar.jpg');
    }

}
