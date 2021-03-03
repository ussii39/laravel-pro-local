<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activation;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationCreated;
use App\User;
use JWTAuth;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $activation = new Activation;
        $activation->email = $request->email;
        $activation->code = Uuid::uuid4();
        $activation->save();
        Mail::to($activation->email)->send(new ActivationCreated($activation));
    }
    public function getcode($code) {
        $user = Activation::where('code', $code)->get();
        return response($user);
    }

    public function activate(Request $request) {
        $code = $request->code;
        if(!$this->checkCode($code)){
          return response()->json(
           ['errors' => ['key' => ['認証キーが無効です。']]]
         , 401);
        }
        $activation = Activation::where('code',$code)
        ->orderBy('created_at','desc')
        ->firstorFail();

        $user = User::create([
          'name' => $request->name,
          'email' => $activation->email,
          'password' => bcrypt($request->password),
        ]);
        
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('token'));
    }


    private function checkCode($code){
        $activation = Activation::where('code',$code)
        ->first();
        if(!$activation){
          return false;
        }
        $email = $activation->email;
        $latest = Activation::where('email',$email)
        ->orderBy('created_at', 'desc')
        ->first();
        $user = User::where('email',$email)->first();
        return $code === $latest->code && !$user;
    }

}
