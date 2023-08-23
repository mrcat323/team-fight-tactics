<?php

namespace App\Http\Controllers;

use App\Jobs\SubscribeJob;
use App\Models\Subcribers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subcribers,email',
        ]);

        $email = $validated['email'];
        $hash = Str::random(40);

        $sub = Subcribers::create([
            'email' => $email,
            'email_verified' => $hash,
        ]);

        $HOST = env('SOUL_HOST') .":". env('SOUL_PORT');
        $client = new Client([
            'base_uri' => $HOST
        ]);
        $response = $client->post('api/login', [
            'json' => [
                'email' => env('SOUL_USER'),
                'password' => env('SOUL_PASSWORD'),
            ],
        ]);
        if ($response->getStatusCode() === 200) {
            $token =  json_decode($response->getBody(), true);

            $status = 0;
            $response = $client->post('api/subscriber-add', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $email,
                    'email_verified' => $hash,
                    'status' => $status,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return response()->json([
                    'status' => 'OK'
                ]);
            }
            else {
                return response()->json([
                    'status' => 'False'
                ]);
            }
        }

        return response()->json([
            'status' => 'False'
        ]);

//        $data = [
//            'email' => $email,
//            'verification_code' => $hash
//        ];
//
//       dispatch(new SubscribeJob($data));
//
//        return response()->json([
//            'msg' => 'Sent successfully'
//        ]);
    }

//
//    public function verify(Request $request)
//    {
//
//        $verify = Subcribers::where('email_verified', $request->hash)->first();
//        if ($verify) {
//            $hash = Str::random(40);
//            $verify->status = true;
//            $verify->email_verified = $hash;
//            $verify->save();
//
//            return response()->json([
//                'msg' => 'Email sent successfully'
//            ]);
//        }
//
//        return response()->json([
//            'msg' => 'Email not found'
//        ]);
//    }
//    public function unVerify(Request $request)
//    {
//        $verify = Subcribers::where('email_verified', $request->hash)->first();
//        if ($verify) {
//            $hash = Str::random(40);
//            $verify->status = false;
//            $verify->email_verified = $hash;
//            $verify->save();
//            return response()->json([
//                'msg' => 'Successfully unsubscribed'
//            ]);
//        }
//
//        return response()->json([
//            'msg' => 'Email not found'
//        ]);
//    }

}
