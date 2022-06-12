<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $erro = '';
        if ($request->get('erro') == 1) {
            $erro = "Usuário e ou senha não existe";
        }

        if ($request->get('erro') == 2) {
            $erro = "Necessário realizar login para ter acesso a pagina";
        }
        return view('site.login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    public function autenticar(Request $request)
    {
        $regras = ['usuario' => 'email', 'senha' => 'required'];

        //as mensagens de feedback de validacao

        $feedback = ['usuario.email' => 'O campo usuário (e-mail) é obrigatório', 'senha.required' => 'O campo senha é obrigatório'];

        $request->validate($regras, $feedback);
        $email = $request->get('usuario');
        $password = $request->get('senha');
        echo "Usuário: $email | Senha: $password";
        echo '<br>';
        $user = new User();
        // comparando o email e o password igualadando e retorna uma coleção de registros com base na consulta
        $usuario = $user->where('email', $email)->where('password', $password)->get()->first();
        if (isset($usuario->name)) {
            session_start();
            // inicia a sessao para pegar a superglobal session
            $_SESSION['nome'] = $usuario->name;
            $_SESSION['email'] = $usuario->email;
            return redirect()->route('app.home');
        } else {
            return redirect()->route('site.login', ['erro' => 1]);
        }
        // echo '<pre>';
        // print_r($usuario);
        // echo '</pre>';

    }

    public function sair()
    {
session_destroy();
return redirect()->route('site.index');
    }
}
