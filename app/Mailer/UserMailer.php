<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/10/26
 * Time: 11:45
 *
 */

namespace App\Mailer;

use App\User;
use Auth;


class UserMailer extends Mailer
{
    public function followNotifyEmail($email, $emailTitle, $emailSenderAddress)
    {
        $data = [
            'url' => 'http://zhihu.dev',
            'name' => Auth::guard('api')->user()->name
        ];
        $this->sendTo('zhihu_new_follower', $data, $email, $emailTitle, $emailSenderAddress);

    }

    public function userRegister(User $user, $emailTitle, $emailSenderAddress)
    {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name
        ];

        $this->sendTo('zhihu_register', $data, $user->email, $emailTitle, $emailSenderAddress);
    }
}