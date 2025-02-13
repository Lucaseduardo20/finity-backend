<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->all();
        $user = User::query()->where('user', $credentials['user'])->first();
        if(!$user) {
            return response()->json(['error' => 'Usuário não encontrado!'], 422);
        }

        if(!Hash::check($credentials['password'], $user->password)){
            return response()->json(['error' => 'Senha incorreta!'], 422);
        }

        return response()->json(['message' => 'Login bem-sucedido!', 'token' => JWTAuth::fromUser($user)]);
    }
}
