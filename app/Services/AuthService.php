<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService{

    public function authCheck($data){

        if(Auth::attempt($data)){
            $userData = Auth::user();
            $token = $userData->createToken('auth_token')->plainTextToken;

            if($userData){
                return response()->json([
                    'code'  => 200,
                    'data'  => $userData->only(['id', 'name', 'email']),
                    'token'=>$token,
                    'message' => 'User login successfully',
                ],200);
            }else{
                return response()->json([
                    'code'  => 400,
                    'message' => 'Something want wrong | Invalid User',
                ],400);
            }
        }else{
            return response()->json([
                'code'  => 400,
                'message' => 'Invalid Credentils',
            ],400);
        }
    }
}