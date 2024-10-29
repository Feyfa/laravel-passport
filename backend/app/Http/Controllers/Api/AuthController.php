<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if($validator->fails())
            return response()->json(['status' => 'failed', 'message' => $validator->messages(), 'status_code' => '422'], 422);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) 
        {
            $user = Auth::user();

            $data['name'] = $user->name;
            $data['access_token'] = $user->createToken('access_token')->accessToken;

            return response()->json(['status' => 'success', 'data' => $data, 'status_code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'failed', 'message' => 'name or password wrong', 'status_code' => '401'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:4'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:5']
        ]);

        if($validator->fails())
            return response()->json(['status' => 'failed', 'message' => $validator->messages(), 'status_code' => '422'], 422);

        try
        {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['status' => 'success', 'message' => 'User Regristrasion Success!'], 200);
        }
        catch(\Exception $e)
        {
            return send_error('failed', $e->getMessage(), $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();

        return response()->json(['message' => 'Success Logout']);
    }

    public function show()
    {

    }
}
