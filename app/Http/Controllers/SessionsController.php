<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        //只让未登录用户访问登录页面
        $this->middleware('guest',['only'=>['create']]);
    }

    public function create(){
        return view('sessions.create');
    }

    public function store(Request $request){
        $crenditals=$this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required',
        ]);

        // Auth::attempt()可接收两个参数，第一个参数为需要进行身份验证的数组，第二个参数为是否为用户开启【记住我】功能的布尔值
        //一般情况下，登录状态会被记住2小时，【记住我】功能会将登陆状态延长到5年
        if(Auth::attempt($crenditals,$request->has('remember'))){
            //该用户存在于数据库，且邮箱和密码输入正确  ---登录成功
            session()->flash('success','欢迎回来！');

            // Auth::user()  获取当前登录用户信息
            return redirect()->intended(route('users.show',[Auth::user()]));
        }else{
            //登录失败
            session()->flash('danger','抱歉，输入的邮箱或密码错误！');
            return redirect()->back();
        }
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success','Logout successful！');
        return redirect()->route('login');
    }
}
