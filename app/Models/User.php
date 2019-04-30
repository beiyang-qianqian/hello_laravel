<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    //Notifiable 消息通知相关功能引用
    use Notifiable;


    protected $table='users';
    /**
     * 过滤用户提交的字段，只有该属性中的字段才能被正常更新
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * 在用户实例通过数组或JSON显示时隐藏敏感信息.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function gravatar($size=100){
        $hash=md5(strtolower(trim($this->attributes['email'])));
        return "http://gravatar.com/avatar/$hash?s=$size";

    }
}
