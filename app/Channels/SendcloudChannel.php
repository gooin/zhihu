<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/10/26
 * Time: 10:37
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendcloud($notifiable);
    }
}