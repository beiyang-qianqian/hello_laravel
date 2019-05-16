<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //暂时性关闭安全性保护，$guarded中的字段与$fillable相反
        \Illuminate\Database\Eloquent\Model::unguard();

        //使用call方法指定我们要运行假数据填充的文件
        $this->call(UsersTableSeeder::class);

        //重新开启安全性保护
        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
