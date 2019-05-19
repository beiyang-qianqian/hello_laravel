<?php

namespace App\Models;

use App\Notifications\ResetPassword;
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

    //该方法在用户模型完成初始化后进行加载 ，因此监听事件需放在这里
    public static function boot(){
        parent::boot();

        //在用户创建（注册）前生成激活令牌
        static::creating(function($user){
            $user->activation_token=str_random(30);
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function gravatar($size=100){
        $hash=md5(strtolower(trim($this->attributes['email'])));
        return "http://gravatar.com/avatar/$hash?s=$size";

    }
}
