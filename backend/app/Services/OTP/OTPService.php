<?php

namespace App\Services\OTP;

use App\Models\OTP;
use App\Models\Blocklist;
use Carbon\Carbon;
use App\Traits\HttpResponses;
use App\Services\SMS\Traits\SMSService;

class OTPService
{
    use SMSService, HttpResponses;

    private static function generateOTP(): int
    {
        return random_int(100000, 999999);
    }

    private static function checkIfExceed($mobile): bool
    {
        $count = OTP::withTrashed()->where('mobile', $mobile)->where('status','unverified')->where('expire_at', '>', Carbon::now())->count();
        if($count == 3){
            self::softdeletePreviousOTP($mobile);
            return true;
        }
        return false;

    }

    private function checkIfBlock($mobile)
    {
        return Blocklist::where('mobile', $mobile)->where('expire_at', '>', Carbon::now())->first();
    }

    private static function blockMobile($mobile)
    {
       return Blocklist::create([
            'mobile' => $mobile,
            'created_at' => Carbon::now(),
            'expire_at' => Carbon::now()->addDay()
        ]);
    }

    private static function softdeletePreviousOTP($mobile):void
    {
        $data = OTP::where('mobile', $mobile)
            ->where('status','unverified')
            ->where('expire_at', '>', Carbon::now())
            ->first();

        if(!is_null($data)){
            $data->delete();
        }
    }

    private function storeOTP($mobile, $code)
    {

        $data = OTP::create([
            'mobile' => $mobile,
            'code' => $code,
            'status' => 'unverified',
            'created_at' => Carbon::now(),
            'expire_at' => Carbon::now()->addMinutes(5)
        ]);

        unset($data['code']);
        return $data;

    }

    public function requestOTP($request)
    {

        if (self::checkIfExceed($request->mobile))
        {
            $check = self::checkIfBlock($request->mobile);

            if (!is_null($check))
            {
                $expireDate = date('Y-m-d h:i:a', strtotime($check->expire_at));
                return self::error(null, 429 ,'Your mobile is already blocked please try again on '.$expireDate);
            }
            else
            {
                $data = self::blockMobile($request->mobile);
                $expireDate = date('Y-m-d h:i:a', strtotime($data->expire_at));
                return self::error(null, 429 ,'You have reached the OTP limit and your mobile has been blocked, please try again on '.$expireDate);
            }
        }


        $code = self::generateOTP();

        $to = '639150390094';
        $from = 'FOODMONKEY';
        $message = 'Do not disclose One-Time Passwords to anyone. Your code is '.$code.', valid for 5 minutes.';

        //ENABLE THIS IN PRODUCTION
        // $response = self::createSMS($to,$from,$message);

        // if  ($response->current()->getStatus() == 0)

        if (true)
        {
        self::softdeletePreviousOTP($request->mobile);

        $data = self::storeOTP($request->mobile, $code);

        return self::success($data, 200, 'We have sent OTP on your mobile number');

        }

        return self::error(null, 429 ,'Something went wrong');

    }

    public function verifyOTP($request)
    {
        $data = OTP::where('mobile', $request->mobile)
            ->where('code', $request->code)
            ->where('status', 'unverified')
            ->where('expire_at', '>' ,Carbon::now())
            ->latest()
            ->first();

        if (!is_null($data)) {
            $data->update(['status' => 'verified']);
            $data->delete();
            return self::success($data, 200, "OTP successful!");
        }

        return self::error($data, 404, 'You entered wrong code, please try again');
    }
    
}//END CLASS
