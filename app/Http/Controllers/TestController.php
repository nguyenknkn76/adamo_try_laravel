<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    // public function showHelloPage(){
    //     $result = funcHelloWorld('Nguyen');
    //     return view('hello',['result' => $result]);
    // }
    
    public function tryCallThirdPartyApi(String $term)
    {   
        $url = 'https://api.dictionaryapi.dev/api/v2/entries/en/'.$term;
        $client = new Client(['verify' => 'D:\Intern PHP\Projects\fdemo\cacert.pem']);
        $res = $client->request('GET', $url);
        $data = json_decode($res->getBody(), true);
        return response()->json($data);
    }

    public function trySendOTPWithSMS (Request $request)
    {
        $id = 1;
        $phoneno = `+84876127602`;
        $otp = 111222;
        $user = User::findOrFail($id);
        $otpService = new OTPService(env('TWILIO_SID'), env('TWILIO_TOKEN'), env('TWILIO_FROM'));
        $otpService->sendOTP($request->phone, $request->otp);
        return response()->json(["message" => "send sms otp success"]);
    }
}
