<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class UsersController extends Controller
{

    public function __construct()
    {
        //除了except指定的动作，其他动作需要登录后才能使用
        $this->middleware('auth',['except'=>['show','create','store','index','confirmEmail']]);
        //只让未登录的用户访问注册用户页面
        $this->middleware('guest',['only'=>['create']]);
    }
    public function index(){
        $users=User::paginate(10);
        return view('users.index',compact('users'));
    }

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

       $this->sendEmailConfirmationTo($user);
       session()->flash('success','验证邮件已发送到您注册的邮箱里，请注意查收。');
       return redirect('/');//激活邮件发送成功后，会将用户重定向到首页


       //Auth::login($user);
       //session()方法访问会话实例      flash只在下一次请求内有效，第一个参数是会话的键，第二个参数是会话的值
     //  session()->flash('success','Register successful！');  //我们可以在之后使用session()->get('success');
      // return redirect()->route('users.show',[$user]);  //等同于 $user->id
   }
   public function edit(User $user){
       $this->authorize('update',$user);
       return view('users.edit',compact('user'));
   }

   public function update(User $user,Request $request){
       $this->validate($request,[
           'name'=>'required|max:50',
           'password'=>'nullable|confirmed|min:6',
           ]
       );
       $this->authorize('update',$user);
       $data=[];
       $data['name']=$request->name;
       if($request->password){
           $data['password']=bcrypt($request->password);
       }
       $user->update($data);
       session()->flash('success','个人资料更新成功');
       return redirect()->route('users.show',$user->id);
   }

   public function destroy(User $user){
       //对删除操作进行授权验证
       $this->authorize('destroy',$user);
       $user->delete();
       session()->flash('success','删除成功');
       return back();
   }

   //发送邮件给指定用户，用户注册成功后悔调用此方法发送邮件
   public function sendEmailConfirmationTo($user){
        $view='emails.confirm';//邮件消息的视图名称
        $data=compact('user');//传递给该视图的数据数组
        $from='aufree@qq.com';//发送者
        $name='Aufree';
        $to=$user->email;//接收者
        $subject='感谢注册 Homestead应用！请确认您的邮箱。';//邮件主题

      Mail::send($view,$data,function ($message) use ($from,$name,$to,$subject){
           $message->from($from,$name)->to($to)->subject($subject);
       });

   }

   //完成用户的激活操作
    public function confirmEmail($token){
       $user=User::where('activation_token',$token)->firstOrfail();//查询不到返回404

       $user->activated=true;//改为激活状态
       $user->activation_token=null;//清空激活令牌
       $user->save();

       Auth::login($user);
       session()->flash('success','恭喜你，激活成功！');
       return redirect()->route('users.show',[$user]);
    }
}
