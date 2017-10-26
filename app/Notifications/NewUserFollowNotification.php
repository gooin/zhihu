<?php

namespace App\Notifications;

use App\Channels\SendcloudChannel;
use App\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use Mail;
use Naux\Mail\SendCloudTemplate;
use App\Mailer\Mailer;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['mail'];
        return ['database',SendcloudChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', 'https://laravel.com')
//                    ->line('Thank you for using our application!');
//    }


    public function toDatabase($notifiable)
    {
        return [
            'name' => Auth::guard('api')->user()->name
        ];
    }

    public function toSendcloud($notifiable)
    {
//        // 模板变量
//        $data = [
//            'url' => 'http://zhihu.dev',
//            'name' => Auth::guard('api')->user()->name
//        ];
//        $template = new SendCloudTemplate('zhihu_new_follower',$data);
//
//        Mail::raw($template, function ($message) use ($notifiable) {
//            $message->from('notification@gooin.win', '【知乎】新用户关注通知');
//            $message->to($notifiable->email);
//        });

        (new UserMailer())->followNotifyEmail(
            $notifiable->email,
            '【知乎】新用户关注通知',
            'notification@gooin.win');
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
