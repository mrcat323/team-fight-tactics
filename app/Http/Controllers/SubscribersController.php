<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email=$validated['email'];
        $token = User::getToken();
        $HOST = env('SOUL_HOST') . ":" . env('SOUL_PORT');
        $client = new Client([
            'base_uri' => $HOST
        ]);
            $response = $client->post('api/subscriber-add', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $email
                ],
            ]);

            if ($response->getStatusCode() === 201) {
                return response()->json([
                    'status' => 'OK'
                ]);
            } else {
                return response()->json([
                    'status' => 'False'
                ]);
            }
        }


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
 ///   }

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
