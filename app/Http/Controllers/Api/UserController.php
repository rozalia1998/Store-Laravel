<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponse;

    public function update(Request $request){

        $user = auth()->user();

        $user->update([
            'name'=>$request->name ?? $user->name,
            'email'=>$request->email ?? $user->email,
            'password'=>Hash::make($request->password) ?? $user->password

        ]);

        return $this->SuccessResponse('Updated Profile Successfully');
    }

    public function destroy(){
        $user=auth()->user();
        $user->tokens()->delete();
        $user->delete();
        return $this->SuccessResponse('Your Account Deleted');
    }
}

