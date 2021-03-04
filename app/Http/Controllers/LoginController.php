<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    function login(Request $request) {
         
        $token = $request->token;
        
        $user = User::where('token', $token)->get();
        // if (!$token = auth("api")->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        return response($user);

    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL() * 60
        ]);
    }
}
