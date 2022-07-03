<?php

namespace App\Http\Controllers;

use App\Models\Produto as ModelsProduto;
use App\Models\ProdutoDetalhe;
use App\Models\Unidade;
use App\Produto;
use App\Models\Item;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produtos = Item::with('itemDetalhe','fornecedor')->paginate(10);

        return view('app.produto.index', ['produtos' => $produtos, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = Unidade::all();
        return view('app.produto.create', ['unidades' => $unidades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|min:3|max:40',
            'descricao' => 'required|min:3|max:2000',
            'peso' => 'required|integer',
            'unidade_id' => 'exists:unidades,id',
            //valida se existe na tabela unidades
        ];
        $feedback = [
            'required' => "O campo :attribute deve ser preenchido",
            'nome.min' => "O campo nome deve ter no mínimo 3 caracteres",
            'nome.min' => "O campo nome deve ter no máximo 40 caracteres",
            'descricao.min' => "O campo descrição deve ter no mínimo 3 caracteres",
            'descricao.max' => "O campo descrição deve ter no máximo 2000 caracteres",
            'peso.integer' => "O campo peso deve ser um número inteiro",
            'unidade_id.exists' =>  "A unidade de medida informada não existe",
        ];
        ModelsProduto::create($request->all());
        return redirect()->route('produto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(ModelsProduto $produto)
    {
        dd($produto);
        return view('app.produto.show', ['produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelsProduto $produto)

    {
        $unidades = Unidade::all();
        return view('app.produto.edit', ['produto' => $produto, 'unidades' => $unidades]);
        // return view('app.produto.create', ['produto' => $produto, 'unidades' => $unidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsProduto $produto)
    {
        $request->all();
        $produto->id;
        $produto->update($request->all());
        return redirect()->route('produto.show', ['produto' => $produto->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsProduto $produto)
    {
        $produto->delete();
        return redirect()->route('produto.index', ['produto' => $produto->id]);
    }
}
