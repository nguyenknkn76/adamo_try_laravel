<?php
namespace App\Services;

use Twilio\Rest\Client;

class OTPService
{
    protected $client;
    protected $from;

    public function __construct($sid, $token, $from)
    {
        $this->client = new Client($sid, $token);
        $this->from = $from;
    }

    public function sendOTP($to, $otp)
    {
        $message = "Your OTP is: $otp";
        return $this->client->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }
}
