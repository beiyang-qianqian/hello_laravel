<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    //更新用户的授权策略
    public function update(User $currentUser,User $user){
        //只能自己更新自己的
        return $currentUser->id===$user->id;
    }
    //删除用户的授权策略
    public function destroy(User $currentUser,User $user){
        //当前用户拥有管理员权限切删除的不是自己
        return $currentUser->is_admin && $currentUser->id!=$user->id;
    }
}
