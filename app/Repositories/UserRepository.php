<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/10/16
 * Time: 17:23
 */

namespace App\Repositories;

use App\User;


class UserRepository
{
    public function byID($id)
    {
        return User::find($id);
    }
}