<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all(['email', 'senha']);
        $token = auth('api')->attempt($credenciais);
        //tentativa de autenticação
        if ($token) {
            return response()->json(['token' => $token]);
        } else { //erro de usuario com senha
            return response()->json(['erro' => 'Usuário ou senha inválido'], 403);
            //403 -> forbidden -> proibido (login inválido)
        }
        return 'login';
    }
    public function logout()
    {
         auth('api')->logout();
        return response()->json(['msg'=>'O logout foi realizado com sucesso']);
    }
    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
}
