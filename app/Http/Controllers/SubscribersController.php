<?php

namespace App\Http\Controllers;

use App\Jobs\SubscribeJob;
use App\Models\Subcribers;
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

        $subscriber = Subcribers::create([
            'email' => $email,
            'email_verified' => $hash,
        ]);

        $data = [
            'email' => $email,
            'verification_code' => $hash
        ];

        dispatch(new SubscribeJob($data));

        return response()->json([
            'msg' => 'Sent successfully'
        ]);
    }

    public function verify(Request $request)
    {

        $verify = Subcribers::where('email_verified', $request->hash)->first();
        if ($verify) {
            $hash = Str::random(40);
            $verify->status = true;
            $verify->email_verified = $hash;
            $verify->save();
            return 'Your email has been verified';
        }
        else {
            return 'Email not found';
        }
    }

}
