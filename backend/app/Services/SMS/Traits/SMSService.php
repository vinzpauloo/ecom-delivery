<?php

namespace App\Services\SMS\Traits;

trait SMSService
{

    protected function createSMS($to, $from, $message = null)
    {
        $client = new \Vonage\Client(new \Vonage\Client\Credentials\Basic(getenv('NEXMO_API_KEY'), getenv('NEXMO_API_SECRET')));
        $response = $client->sms()->send(new \Vonage\SMS\Message\SMS($to,$from,$message));
        return $response;
    }

}//END CLASS
