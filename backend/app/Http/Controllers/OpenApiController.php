<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OpenApiController extends Controller
{
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);

        if($validator->fails())
            return response()->json(['status' => 'failed', 'message' => $validator->messages(), 'status_code' => 422], 422);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if(Auth::attempt($credentials)) 
        {
            $user = Auth::user();

            $data['name'] = $user->name;
            $data['access_token'] = $user->createToken('access_token')->accessToken;

            $url = "http://localhost:5174/sso?access_token={$data['access_token']}";

            return response()->json(['status' => 'success', 'data' => $data, 'status_code' => 200, 'url' => $url], 200);
        }
        else 
        {
            $user->delete();
            return response()->json(['status' => 'failed', 'message' => 'name or password wrong', 'status_code' => '401'], 401);
        }
    }

    public function ssotokenvalidation()
    {
        return response()->json(['status' => 200, 'message' => 'token valid'], 200);
    }
}
