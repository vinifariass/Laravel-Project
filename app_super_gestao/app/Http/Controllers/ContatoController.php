<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContato;
use App\Models\MotivoContato;

class ContatoController extends Controller
{
    public function contato(Request $request)
    {
        $motivo_contatos = MotivoContato::all();

        return view(
            'site.contato',
            ['titulo' => 'Contato (teste)', 'motivo_contato' => $motivo_contatos]
        );
    }

    public function salvar(Request $request)
    {
        $regras = [
            'nome' => 'required|min:3|max:40|unique:site_contatos',
            'telefone' => 'required',
            'email' => 'email',
            'motivo_contatos_id' => 'required',
            'mensagem' => 'required|max:2000'
        ];
        $feedback =  [
            'nome.required' => 'O campo nome precisa ser preenchido', //prioritario em relação a generica
            'email.email' => 'O email informado não é válido',
            'mensagem.max' => 'A mensagemd deve ter no máximo 2000 caracteres',
            'nome.min' => 'O campo precisa ter no mínimo 3 caracteres',
            'nome.max' => 'O campo nome deve ter no máximo 40 caracteres',
            'nome.unique' => 'O nome informado já está em uso',
            'required' => 'O campo :attribute deve ser preenchido',
            'telefone.required' => 'O campo telefone precisa ser preenchido'
        ];
        $request->validate($regras,$feedback 
        );
        SiteContato::create($request->all());
        return redirect()->route('site.index');
    }
}
