<?php

namespace App\Traits;

use App\Models\UserOtp;
use App\Helpers\PhoneCleanerHelper;
use Twilio\Rest\Client;

trait SendsOtp
{
    /**
     * Generate and send OTP to user
     */
    public function sendOtp($user)
    {
        try {
            
            $otp = $this->generateOtp();
            $this->storeOtp($user, $otp);
            $this->sendOtpViaTwilio($user, $otp);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('OTP sending failed: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Generate a 6-digit OTP
     */
    protected function generateOtp(): string
    {
        return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Store OTP in database
     */
    protected function storeOtp($user, string $otp): void
    {
        UserOtp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp_code' => $otp,
                'otp_type' => 0,
                'send_to_phone' => (new PhoneCleanerHelper($user->phone))->clean(),
                'failed_attempts_count' => 0,
                'last_failed_attempt_date' => null,
                'last_resend_date' => now(),
                'resend_count' => 0,
                'verified_at' => null,
                'is_otp_verified' => false,
                'expires_at' => now()->addMinutes(5)
            ]
        );
    }

    /**
     * Send OTP via Twilio
     */
    protected function sendOtpViaTwilio($user, string $otp): void
    {
        $phoneNumber = (new PhoneCleanerHelper($user->phone))->clean();
        
        // dd("Sending OTP to: {$phoneNumber} with code: {$otp}");
        $client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $client->messages->create("whatsapp:{$phoneNumber}", [
            'from' => 'whatsapp:' . config('services.twilio.from'),
            'body' => "رمز التحقق الخاص بك لا تشاركه مع اي شخص: {$otp}"
        ]);
    }
}