<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用辅助函数factory生成一个使用假数据的对象
        //创建50个假用户
        $users=factory(\App\Models\User::class)->times(50)->make();
        //makeVisiable方法临时显示User模型里指定的隐藏属性$hidden
        //使用insert将假用户数据插入到数据库中
        \App\Models\User::insert($users->makeVisible(['password','remember_token'])->toArray());


        //更新id为1的用户信息
        $user=\App\Models\User::find(1);
        $user->name='Aufree';
        $user->email='aufree@qq.com';
        $user->password=bcrypt('123456');
        $user->save();
    }
}
