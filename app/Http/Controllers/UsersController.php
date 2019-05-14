<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
   public function create(){
       return view('users.create');
   }

   public function show(User $user){
        return view('users.show',compact('user'));
   }

   public function store(Request $request){
       //validate方法接收两个参数，第一个是用户输入的数据，第二个是输入该数据的验证规则
       $this->validate($request,[
           'name'=>'required|max:50',
           'email'=>'required|email|unique:users|max:255',  //针对数据表users做email的唯一性认证
           'password'=>'required|confirmed|min:6'  //使用confirmed进行密码匹配验证时，确认密码的name属性必须加上 _confirmation后缀
       ]);
       $user=User::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>bcrypt($request->password)
       ]);
       Auth::login($user);
       //session()方法访问会话实例      flash只在下一次请求内有效，第一个参数是会话的键，第二个参数是会话的值
       session()->flash('success','Register successful！');  //我们可以在之后使用session()->get('success');
       return redirect()->route('users.show',[$user]);  //等同于 $user->id
   }
   public function edit(User $user){
       return view('users.edit',compact('user'));
   }

   public function update(User $user,Request $request){
       $this->validate($request,[
           'name'=>'required|max:50',
           'password'=>'nullable|confirmed|min:6',
           ]
       );
       $data=[];
       $data['name']=$request->name;
       if($request->password){
           $data['password']=bcrypt($request->password);
       }
       $user->update($data);
       session()->flash('success','个人资料更新成功');
       return redirect()->route('users.show',$user->id);
   }
}
