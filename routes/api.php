<?php

use Illuminate\Http\Request;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'jwt.auth'], function () {
});

Route::group(["middleware" => "guest:api"], function () {
});

// Route::post("/login", "LoginController@login");
Route::group(["middleware" => "auth:api"], function () {
});

// Route::get('me', 'AuthenticateController@getCurrentUser');
Route::get('register/{code}', 'RegisterController@getcode');
Route::post('register', 'RegisterController@register');
Route::post('activate', 'RegisterController@activate');
Route::post('authenticate', 'AuthenticateController@authenticate');
Route::get('login', 'LoginController@Login');

Route::middleware(['api','cors'])->group(function () {
Route::get('answer', 'TodoController@index');
Route::post('answer', 'TodoController@store');
Route::put('answer/{id}', 'TodoController@put');




Route::post("/login",function(){
    $email = request()->get("email");
    $password = request()->get("password");
    $user = User::where("email",$email)->first();
    if ($user && Hash::check($password, $user->password)) {
     $token = str_random();
     $user->token = $token;
     $user->save();
     return [
      "token" => $token,
      "user" => $user
     ];
    }else{
     abort(401);
    }
   });

   Route::post("/logout",function(){
    $token = request()->bearerToken();
    $user = User::where("token",$token)->first();
    if ($token && $user) {
     $user->token = null;
     $user->save();
     return [];
    }else{
     abort(401);
    }
   });

    Route::get('/users','UsersController@index');
});