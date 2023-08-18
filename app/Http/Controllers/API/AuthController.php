<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\AuthJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register', 'verify']);
    }

    public function register(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|max:32'
        ]);
        if ($validate->passes()) {
            $hash = Str::random(60);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'hash' => $hash
            ]);

            $dataMail =[
                'email' => $request->email,
                'verification_code' => $hash
            ];
            dispatch(new AuthJob($dataMail));
            return response()->json(['message' => 'User registered successfully']);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', $credentials['email'])->first();
        if (!$user->email_verified_at || !$token = auth('api')->attempt($credentials)){
            return response()->json(['error'=> 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function user()
    {
        return response()->json(auth('api')->user());
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'type' => 'Bearer',
            'expires_in' => \Config::get('jwt.ttl') * 60
        ]);
    }
    public function verify(Request $request)
    {
        $verify = User::where('hash', $request->hash)->first();

        if ($verify->email_verified_at) {
            return 'Your email already verified';
        }
        elseif ($verify) {
            $verify->email_verified_at = Carbon::now();
            $verify->save();
            return 'Your email has been verified';
        }
        else {
            return 'Email not found';
        }
    }
}
