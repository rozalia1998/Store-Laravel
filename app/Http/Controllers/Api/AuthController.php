<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Jobs\MakeStatus;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request){
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token=$user->createToken('token')->plainTextToken;
        return $this->apiResponse($token,'Registeration Success',200);
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Login information is invalid', 401);
         }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('myApp')->plainTextToken;
        $data['name']=$user->name;
        $data['token']=$token;

        return $this->apiResponse($data,'Login success', 200);
    }

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        return $this->SuccessResponse('user logged out');
     }

     public function changeStatus(){
        //Request $request, changeStatus::dispatch($request)->delay(now()->second(30));

        MakeStatus::dispatch();
        return 'action is processed';
     }

     public function notificate(){
        $user=Auth::user();

        $res=$user->notifications;

        return $this->apiResponse($res,'Notification');
     }
}
