<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);
        //atributo de marca controller que é iniciado no construct
      

        if ($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
            //passar o filtro de pesquisa
        }


        if ($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
            //''id,nome,imagem
            //selectRaw -> seleciona como uma string unica
        }

        //$marcas = Marca::all();
        // $marcas = $this->marca->with('marcas')->get();
        return response()->json($locacaoRepository->getResultado(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->locacao->rules(), $this->locacao->feedback());

        $locacao = $this->locacao->create([
            'cliente_id' => $request->cliente_id,
            'carro_id' => $request->carro_id,
            'data_inicio_periodo' => $request->data_inicio_periodo,
            'data_final_prevista_periodo' => $request->data_final_prevista_periodo,
            'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
            'valor_diaria' => $request->valor_diaria,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final,
        ]);

        return response()->json($locacao, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locacao = $this->locacao->find($id);
        if ($locacao === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        return response()->json($locacao, 200);
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($locacao->rules() as $input => $regra) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);
        } else {
            $request->validate($locacao->rules());
        }

        $locacao->fill($request->all());
        $locacao->save();
        // $locacao->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

        return response()->json($locacao, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, $id)
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        Storage::disk('public')->delete($locacao->imagem);

        $locacao->delete();
        return response()->json(['msg' => 'A locacao foi removida com sucesso!'], 200);
    }
}
