<?php

namespace App\Http\Controllers;

use App\Jobs\SendOtpEmail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;

class PasswordResetController extends Controller
{   
    protected function sendOtpEmail($email, $otp)
    {
        // Mail::to($email)->send(new OtpMail($otp));
        dispatch(new SendOtpEmail($email, $otp));
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $expires_at = Carbon::now()->addMinutes(10);

        Otp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expires_at]
        );

        //todo push sending mail job to queue (SUS)
        // Queue::push(function() use($request, $otp){
        //     Mail::to($request->email)->send(new OtpMail($otp));
        // });

        $this->sendOtpEmail($request->email, $otp);

        //! NON  RQ: reduce using ram 
        // Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $otpEntry = Otp::where('email', $request->email)
                        ->where('otp', $request->otp)
                        ->first();

        if (!$otpEntry || $otpEntry->expires_at < Carbon::now()) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $otpEntry->delete();

        return response()->json(['message' => 'Password reset successful.']);
    }

    // public function testEmail()
    // {
    //     $name = 'test name for email';
    //     Mail::send('emails.test', ['name' => $name], function ($email) use ($name) {
    //         $email->subject('demo subject');
    //         $email->to('uiojklzxc02@gmail.com', $name);
    //     });
    // }
}

