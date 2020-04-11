<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name','email','password','currency_id'
    ];
    protected $hidden = [
        'password','remember_token'
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function getUserId(){
        return $this->primaryKey;
    }

    public function setPasswordAttribute($password){
        if(!empty($password)){
            $this->attributes['password'] = bcrypt($password);
        }
    }

}
