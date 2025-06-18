<?php

namespace App\Notifications;

use App\Helpers\PhoneCleanerHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use App\Models\UserOtp;
use App\Notifications\Channels\TwilioSmsChannel;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $otp;
    
    public function __construct()
    {
        $this->otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function via($notifiable)
    {
         return [TwilioSmsChannel::class];
    }

    public function toTwilioSms($notifiable)
    {
        \Log::info('📤 Sending OTP to: ' . $this->otp);
        UserOtp::create([
            'user_id' => $notifiable->id,
            'otp_code' => $this->otp,
            'is_otp_verified' => false,
            'expires_at' => now()->addMinutes(5),
        ]);

        $client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $phoneNumber = (new PhoneCleanerHelper($notifiable->phone))->clean();

        $client->messages->create("whatsapp:$phoneNumber", [
                'from' => config('services.twilio.from'),
                'body' => "رمز التحقق الخاص بك هو: {$this->otp}",
            ]
        );
    }
}
