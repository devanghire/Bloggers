<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function login(AuthService $AuthService,LoginRequest $loginReq)
    {
        $data = $loginReq->validated();
        $userData = $AuthService->authCheck($data);
        $response = $userData->getData(true);
        return response()->json($response,$response['code']);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
