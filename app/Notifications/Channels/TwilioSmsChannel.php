<?php


namespace App\Notifications\Channels;


use Illuminate\Notifications\Notification;


class TwilioSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $notification->toTwilio($notifiable);
        return true;
    }
}
