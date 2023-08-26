<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use ApiResponse;

    public function sendResetLink(Request $request){
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));
        return $response === Password::RESET_LINK_SENT
                    ? $this->SuccessResponse('Password reset email sent')
                    : $this->errorResponse('Unable to send password reset email');
    }

}
