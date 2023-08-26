<?php

namespace App\Http\Controllers\Api;

Trait ApiResponse{

    public function apiResponse($data=[],$message=null,$code=200){
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data
        ],$code);
    }

    public function errorResponse($message=null,$code=403){
        return response()->json([
            'status'=>false,
            'message'=>$message,
        ],$code);
    }
    public function SuccessResponse($message=null,$code=200){
        return response()->json([
            'status'=>true,
            'message'=>$message,
        ],$code);
    }

}
