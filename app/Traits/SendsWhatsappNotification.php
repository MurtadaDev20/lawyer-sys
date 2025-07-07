<?php

namespace App\Traits;

use App\Helpers\PhoneCleanerHelper;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

trait SendsWhatsappNotification
{
    public function sendWhatsappMessage($user, string $message): bool
    {
        try {
            $phoneNumber = (new PhoneCleanerHelper($user->phone))->clean();

            $client = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $client->messages->create("whatsapp:{$phoneNumber}", [
                'from' => 'whatsapp:' . config('services.twilio.from'),
                'body' => $message
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp Notification Failed: ' . $e->getMessage());
            return false;
        }
    }
}