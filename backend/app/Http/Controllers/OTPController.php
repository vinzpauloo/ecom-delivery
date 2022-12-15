<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OTP\OTPService;
use App\Models\OTP;
use Carbon\Carbon;

class OTPController extends Controller
{
    protected $otpservice;
    
    public function __construct(OTPService $otpservice)
    {
        $this->otpservice = $otpservice;
    }

    public function requestOTP(Request $request)
    {
        return $this->otpservice->requestOTP($request);
    }

    public function verifyOTP(Request $request)
    {
        return $this->otpservice->verifyOTP($request);
    }

}
