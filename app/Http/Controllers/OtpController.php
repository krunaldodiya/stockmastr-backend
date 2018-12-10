<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Http\Requests\Login;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Otp;
use Exception;
use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;
use App\Http\Requests\RequestOtp;
use App\Http\Requests\VerifyOtp;
use App\Exceptions\OtpVerificationFailed;

class OtpController extends Controller
{
    protected function otpAuth($mobile, $otp, $type, $production)
    {
        if ($production) {
            if ($type == 'request') {
                return LaravelMsg91::sendOtp($mobile, $otp, "Your otp for phone verification is $otp");
            }

            if ($type == 'verify') {
                return LaravelMsg91::verifyOtp($mobile, $otp, ['raw' => true]);
            }
        }

        return (object)['message' => 'otp_verified'];
    }

    public function requestOtp(RequestOtp $request)
    {
        $production = env('APP_ENV') == 'production';

        $mobile = $request->mobile;
        $otp = $production ? mt_rand(1000, 9999) : 1234;

        try {
            $requestOtp = $this->otpAuth($mobile, $otp, 'request', $production);

            return $requestOtp ? ['mobile' => $mobile, 'otp' => $otp] : false;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function verifyOtp(VerifyOtp $request)
    {
        $production = env('APP_ENV') == 'production';

        $mobile = $request->mobile;
        $otp = $request->otp;

        try {
            $verifyOtp = $this->otpAuth($mobile, $otp, 'verify', $production);

            if ($verifyOtp->message == 'otp_verified') {
                $firstOrCreate = User::firstOrCreate(['mobile' => $mobile]);
                $user = $firstOrCreate->email ? $firstOrCreate : User::find($firstOrCreate->id);

                $token = $user->createToken('SocialStock', [])->accessToken;
                return compact('user', 'token');
            }

            throw new OtpVerificationFailed($verifyOtp->message);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
