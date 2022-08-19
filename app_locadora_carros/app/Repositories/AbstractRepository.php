<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository{
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function selectAtributosRegistrosRelacionados($atributos)
  {
    $this->model = $this->model->with($atributos);
    // a query está sendo montada ela pega o resultado atualizado ao atributo do repository para formatar com varias instrucoes dentro da mesma query
  }

  public function filtro($filtros)
  {
    $filtros = explode(';', $filtros);
    //funcao filtros sera convertida em array

    foreach ($filtros as $key => $condicao) {
      $c = explode(':', $condicao);
      $this->model = $this->model->where($c[0], $c[1], $c[2]);
      //pega a ultima query montada e atualiza o atributo anterior
    }
  }

  public function selectAtributos($atributos)
  {
    $this->model = $this->model->selectRaw($atributos);
  }

  public function getResultado()
  {
    return $this->model->get();
  }
}
