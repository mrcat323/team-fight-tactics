<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function register(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|max:32'
        ]);
        if ($validate->passes()) {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            return response()->json(['message' => 'User registered successfully']);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)){
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

}
