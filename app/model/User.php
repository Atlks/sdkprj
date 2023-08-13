<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class User extends Model
{
    //
    function findByUserId($user_id)
    {
        return User::where('Tg_Id', $user_id)->find();
    }
}
