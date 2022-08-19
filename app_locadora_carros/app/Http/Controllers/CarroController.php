<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Models\Marca;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);
        //atributo de marca controller que é iniciado no construct
        if ($request->has('atributos_modelo')) {
            $atributos_modelo = 'modelo:id,' . $request->atributos_modelo;
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if ($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
            //passar o filtro de pesquisa
        }


        if ($request->has('atributos')) {
            $carroRepository->selectAtributos($request->atributos);
            //''id,nome,imagem
            //selectRaw -> seleciona como uma string unica
        }

        //$marcas = Marca::all();
        // $marcas = $this->marca->with('marcas')->get();
        return response()->json($carroRepository->getResultado(), 200);
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
        $request->validate($this->carro->rules(), $this->carro->feedback());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);

        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = $this->carro->with('modelo')->find($id);
        if ($carro === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        return response()->json($carro, 200);
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
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
        $carro = $this->carro->find($id);

        if ($carro === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($carro->rules() as $input => $regra) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);
        } else {
            $request->validate($carro->rules());
        }

        $carro->fill($request->all());
        $carro->save();
        // $carro->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

        return response()->json($carro, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $carro = $this->carro->find($id);

        if ($carro === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        Storage::disk('public')->delete($carro->imagem);

        $carro->delete();
        return response()->json(['msg' => 'O carro foi removido com sucesso!'], 200);
    }
}
