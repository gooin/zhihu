<?php
/**
 * Created by PhpStorm.
 * User: gooin
 * Date: 2017/10/26
 * Time: 11:44
 */

namespace App\Mailer;

use Naux\Mail\SendCloudTemplate;
use Mail;


class Mailer
{

    protected function sendTo($template, Array $data, $email, $emailTitle, $emailSenderAddress)
    {
        // 模板变量
        $content = new SendCloudTemplate($template, $data);

//        Mail::raw($content, function ($message) use ($email) {
//            $message->from('notification@gooin.win', '【乎知】');
//            $message->to($email);
//        });

        Mail::raw($content, function ($message) use ($email, $emailTitle, $emailSenderAddress) {
            $message->from($emailSenderAddress, $emailTitle);
            $message->to($email);
        });
    }

}