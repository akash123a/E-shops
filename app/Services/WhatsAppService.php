<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function sendMessage($to, $message)
    {
        try {
            // WhatsApp direct link (without Twilio)
            $url = "https://wa.me/91{$to}?text=" . urlencode($message);

            Log::info("WhatsApp URL: " . $url);

            return $url; // return link
        } catch (\Exception $e) {
            Log::error("WhatsApp Error: " . $e->getMessage());
        }
    }
}